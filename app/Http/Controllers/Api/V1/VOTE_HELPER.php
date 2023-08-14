<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Candidat;
use App\Models\CandidatVote;
use App\Models\Elector;
use App\Models\ElectorVote;
use App\Models\Vote;
use App\Models\VoteStatus;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class VOTE_HELPER extends BASE_HELPER
{
    ##======== VOTE VALIDATION =======##
    static function vote_rules(): array
    {
        return [
            'name' => ['required', Rule::unique('votes')],
            'status' => ['required'],
            'start_vote' => ['required'],
            'end_vote' => ['required'],
            'candidats' => ['required'],
        ];
    }

    static function vote_messages(): array
    {
        return [
            // 'name.required' => 'Le name est réquis!',
            // 'name.uniq' => 'Ce Champ est un mail!',
            // 'phone.required' => 'Le phone est réquis!',
            // 'phone.unique' => 'Le phone est existe déjà!',
        ];
    }

    static function Vote_Validator($formDatas)
    {
        #
        $rules = self::vote_rules();
        $messages = self::vote_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##======== VOTE AFFECTATION TO ELECTOR VALIDATION =======##
    static function vote_affect__rules(): array
    {
        return [
            'vote_id' => ['required', "integer"],
            'elector_id' => ['required', "integer"],
        ];
    }

    static function vote_affect_messages(): array
    {
        return [
            // 'name.required' => 'Le name est réquis!',
            // 'name.uniq' => 'Ce Champ est un mail!',
            // 'phone.required' => 'Le phone est réquis!',
            // 'phone.unique' => 'Le phone est existe déjà!',
        ];
    }

    static function Vote_affect_Validator($formDatas)
    {
        #
        $rules = self::vote_affect__rules();
        $messages = self::vote_affect_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }


    static function createVote($request)
    {
        $formData = $request->all();
        $status = VoteStatus::where("id", $formData["status"])->get();
        if ($status->count() == 0) {
            return self::sendError("Ce status n'existe pas!", 404);
        }

        $user =  request()->user();

        if ($user->is_super_admin) { #S'IL EST UN SUPER ADMIN
            #ON VERIFIE JUSTE L'ORGANISATION VIA SON ID
            $organisation_id = null;
        } else { #S'IL N'EST PAS UN SUPER ADMIN
            #ON RECUPERE SON ORGANISATION
            $user_organisation_id = $user->organisation; #recuperation de l'ID de l'organisation affectée au user
            $organisation = Get_User_Organisation($user_organisation_id);
            $organisation_id = $organisation->id;
        }
        $formData["organisation"] = $organisation_id;

        #TRAITEMENT DU CHAMP **candidats** renseigné PAR LE USER
        $candidats = $formData["candidats"];
        // return $candidats;
        $candidats_ids = explode(",", $candidats);
        foreach ($candidats_ids as $id) {
            $candidat = Candidat::where(["id" => $id, "owner" => $user->id])->get();
            if ($candidat->count() == 0) {
                return self::sendError("Le candidat d'id :" . $id . " n'existe pas!", 404);
            }
        }

        #TRAITEMENT DU CHAMP **electors** S'IL EST renseigné PAR LE USER
        if ($request->get("electors")) {
            $electors = $formData["electors"];
            $electors_ids = explode(",", $electors);
            foreach ($electors_ids as $id) {
                $elector = Elector::where(["id" => $id, "owner" => $user->id])->get();
                if ($elector->count() == 0) {
                    return self::sendError("L'electeur d'id :" . $id . " n'existe pas!", 404);
                }
            }
        }

        $vote = Vote::create($formData);
        $vote->owner = request()->user()->id;
        $vote->save();

        #AFFECTATION DU CANDIDAT AU VOTE 
        foreach ($candidats_ids as $id) {
            $this_candidate_vote = CandidatVote::where(["candidat_id" => $id, "vote_id" => $vote->id])->get();
            #On verifie d'abord si ce attachement existait déjà 
            if ($this_candidate_vote->count() == 0) {
                $candidat = Candidat::where(["id" => $id, "owner" => $user->id])->get();
                $vote->candidats()->attach($candidat);
            }
        }

        #AFFECTATION DE L'ELECTEUR AU VOTE S'IL LE CHAMP EST RENSEIGNE PAR LE USER
        if ($request->get("electors")) {
            foreach ($electors_ids as $id) {
                $this_elector_vote = ElectorVote::where(["elector_id" => $id, "vote_id" => $vote->id])->get();
                #On verifie d'abord si ce attachement existait déjà 

                if ($this_elector_vote->count() == 0) {
                    $elector = Elector::where(["id" => $id, "owner" => $user->id])->get();
                    $vote->electors()->attach($elector);
                }

                #Ajout du code secret dans la table **eletors_votes**
                $this_elector_vote = ElectorVote::where(["elector_id" => $id, "vote_id" => $vote->id])->get();
                
                $this_elector_vote = $this_elector_vote[0];
                $elector_vote = ElectorVote::find($this_elector_vote->id);
                $elector_vote->secret_code = Str::uuid();
                $elector_vote->save();
            }
        }

        #=====ENVOIE D'SMS =======~####
        #AUX ELECTEURS DU VOTE SI L'UTILISATEUR LES RENSEIGNE
        if ($request->get("electors")) {
            foreach ($electors_ids as $id) {
                $elector = Elector::where(["id" => $id, "owner" => $user->id])->get()[0];
                $sms_login =  Login_To_Frik_SMS();

                if ($sms_login['status']) {
                    $token =  $sms_login['data']['token'];
                    $vote_url = env("BASE_URL") . "/vote/" . $elector->identifiant . "/" . $elector->secret_code . "/" . $vote->id;
                    Send_SMS(
                        $elector->phone,
                        "Vous avez été affecté au vote " . $vote->name . " en tant qu'electeur sur e-voting! Cliquez ici pour voter: " . $vote_url,
                        $token
                    );
                }
            }
        }

        return self::sendResponse($vote, 'Vote crée avec succès!!');
    }

    static function getVotes()
    {
        $vote =  Vote::with(["status", 'owner', "candidats", "electors"])->where(["owner" => request()->user()->id])->orderBy("id", "desc")->get();
        return self::sendResponse($vote, 'Tout les votes récupérés avec succès!!');
    }

    static function retrieveVotes($id)
    {
        $vote = Vote::with(["status", 'owner', "candidats", "electors"])->where(["owner" => request()->user()->id, "id" => $id])->get();
        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        }
        return self::sendResponse($vote, "Vote récupéré(e) avec succès:!!");
    }

    static function updateVotes($request, $id)
    {
        $formData = $request->all();
        $user = request()->user();

        $vote = Vote::where(['id' => $id, 'owner' => request()->user()->id])->get();
        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        }

        $vote = $vote[0];

        #FILTRAGE POUR EVITER LES DOUBLONS
        if ($request->get("name")) {
            $name = Vote::where(['name' => $formData['name'], 'owner' => request()->user()->id])->get();

            if (!count($name) == 0) {
                return self::sendError("Ce name existe déjà!!", 404);
            }
        }

        #TRAITEMENT DU CHAMP **electors** S'IL EST renseigné PAR LE USER
        if ($request->get("electors")) {
            $electors = $formData["electors"];
            $electors_ids = explode(",", $electors);
            foreach ($electors_ids as $id) {
                $elector = Elector::where(["id" => $id, "owner" => $user->id])->get();
                if ($elector->count() == 0) {
                    return self::sendError("L'electeur d'id :" . $id . " n'existe pas!", 404);
                }
            }

            #AFFECTATION DE L'ELECTEUR AU VOTE S'IL LE CHAMP EST RENSEIGNE PAR LE USER
            foreach ($electors_ids as $id) {
                $this_elector_vote = ElectorVote::where(["elector_id" => $id, "vote_id" => $vote->id])->get();
                #On verifie d'abord si ce attachement existait déjà 
                if ($this_elector_vote->count() == 0) {
                    $elector = Elector::where(["id" => $id, "owner" => $user->id])->get();
                    $vote->electors()->attach($elector);
                }
            }
        }

        #TRAITEMENT DU CHAMP **candidats** renseigné PAR LE USER
        if ($request->get("candidats")) {
            $candidats = $formData["candidats"];
            $candidats_ids = explode(",", $candidats);
            foreach ($candidats_ids as $id) {
                $candidat = Candidat::where(["id" => $id, "owner" => $user->id])->get();
                if ($candidat->count() == 0) {
                    return self::sendError("Le candidat d'id :" . $id . " n'existe pas!", 404);
                }
            }

            #AFFECTATION DU CANDIDAT AU VOTE 
            foreach ($candidats_ids as $id) {
                $this_candidate_vote = CandidatVote::where(["candidat_id" => $id, "vote_id" => $vote->id])->get();
                #On verifie d'abord si ce attachement existait déjà 
                if ($this_candidate_vote->count() == 0) {
                    $candidat = Candidat::where(["id" => $id, "owner" => $user->id])->get();
                    $vote->candidats()->attach($candidat);
                }
            }
        }

        $elector = $vote;
        $elector->update($formData);
        return self::sendResponse($elector, "Vote modifié(e) avec succès:!!");
    }

    static function voteDelete($id)
    {
        $vote = Vote::where(['id' => $id, 'owner' => request()->user()->id])->get();
        if (count($vote) == 0) {
            return self::sendError("Ce Vote n'existe pas!", 404);
        };
        $vote = $vote[0];
        $vote->visible = false;
        $vote->delete_at = now();
        // return $vote;
        $vote->save();
        return self::sendResponse($vote, 'Ce Vote a été supprimé avec succès!');
    }

    static function AffectToElector($request)
    {
        $formData = $request->all();
        $elector = Elector::where(['id' => $formData['elector_id'], 'owner' => request()->user()->id])->get();
        if ($elector->count() == 0) {
            return self::sendError("Ce electeur n'existe pas!", 404);
        };

        $vote = Vote::where(['id' => $formData['vote_id'], 'owner' => request()->user()->id])->get();
        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        };

        $vote = $vote[0];

        $vote->electors()->attach($elector);

        #++====== ENVOIE D'SMS AU ELECTEUR +++++=======
        $sms_login =  Login_To_Frik_SMS();

        if ($sms_login['status']) {
            $token =  $sms_login['data']['token'];
            $vote_url = env("BASE_URL") . "/vote/" . $elector[0]->identifiant . "/" . $elector[0]->secret_code . "/" . $vote->id;
            Send_SMS(
                $elector[0]->phone,
                "Vous avez été affecté au vote " . $vote->name . " en tant qu'electeur sur e-voting! Cliquez ici pour voter: " . $vote_url,
                $token
            );
        }

        return self::sendResponse($vote, "Affectation effectuée avec succès!");
    }
}
