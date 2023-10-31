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
        return [];
    }

    static function Vote_affect_Validator($formDatas)
    {
        #
        $rules = self::vote_affect__rules();
        $messages = self::vote_affect_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##======== RETRAIT DE CANDIDAT D'UN VOTE =======##
    static function candidat_retrieve__rules(): array
    {
        return [
            'vote_id' => ['required', "integer"],
            'candidat_id' => ['required', "integer"],
        ];
    }

    static function candidat_retrieve_messages(): array
    {
        return [];
    }

    static function Candidat_retrieve_Validator($formDatas)
    {
        $rules = self::candidat_retrieve__rules();
        $messages = self::candidat_retrieve_messages();

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
            $organisation_id = $user->organisation; #recuperation de l'ID de l'organisation affectée au user
        }
        $formData["organisation"] = $organisation_id;

        #TRAITEMENT DU CHAMP **candidats** renseigné PAR LE USER
        $candidats_ids = $formData["candidats"];
        // $candidats_ids = explode(",", $candidats_ids);
        foreach ($candidats_ids as $id) {
            $candidat = Candidat::where(["id" => $id, "owner" => $user->id, "visible" => 1])->get();
            if ($candidat->count() == 0) {
                return self::sendError("Le candidat d'id :" . $id . " n'existe pas!", 404);
            }
        }

        #TRAITEMENT DU CHAMP **electors** S'IL EST renseigné PAR LE USER
        if ($request->get("electors")) {
            $electors_ids = $formData["electors"];
            // $electors_ids = explode(",", $electors_ids);
            foreach ($electors_ids as $id) {
                $elector = Elector::where(["id" => $id, "owner" => $user->id, "visible" => 1])->get();
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
                $candidat = Candidat::where(["id" => $id, "owner" => $user->id, "visible" => 1])->get();
                $vote->candidats()->attach($candidat);
            }
        }

        if ($request->get("electors")) {
            foreach ($electors_ids as $id) {
                #AFFECTATION DE L'ELECTEUR AU VOTE Si LE CHAMP EST RENSEIGNE PAR LE USER
                $elector = Elector::where(["id" => $id, "owner" => $user->id])->get();

                $this_elector_vote = ElectorVote::where(["elector_id" => $id, "vote_id" => $vote->id])->get();
                #On verifie d'abord si ce attachement existait déjà 
                if ($this_elector_vote->count() == 0) { #Si ça n'existe pas, on le crée
                    $vote->electors()->attach($elector);
                }

                #Ajout du code secret dans la table **eletors_votes**
                $this_elector_vote = ElectorVote::where(["elector_id" => $id, "vote_id" => $vote->id])->get();

                $this_elector_vote = $this_elector_vote[0];
                $elector_vote = ElectorVote::find($this_elector_vote->id);
                $elector_vote->secret_code = Str::uuid();
                $elector_vote->save();


                #++====== ENVOIE D'SMS AU ELECTEUR +++++=======

                // $vote_url = env("BASE_URL") . "/vote/" . $elector[0]->identifiant . "/" . $elector[0]->secret_code . "/" . $vote->id;
                $message = "Vous avez été affecté.e au vote << " . $vote->name . " >> en tant qu'electeur sur e-voting";

                try {
                    ##======ENVOIE D'SMS======##
                    Send_SMS(
                        $elector[0]->phone,
                        $message,
                    );

                    #=====ENVOIE D'EMAIL =======~####
                    Send_Email(
                        $elector[0]->email,
                        "Vous avez été affecté.e à un vote sur E-VOTING",
                        $message,
                    );
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

        return self::sendResponse($vote, 'Vote crée avec succès!!');
    }

    static function getVotes()
    {
        $user = request()->user();
        if ($user->is_super_admin) { ### S'IL S'AGIT D'UN SUPER ADMIN
            ###il peut tout recuperer
            $vote =  Vote::with(["status", 'owner', "candidats", "electors", "organisation"])->orderBy("id", "desc")->get();
        } else {
            $vote =  Vote::with(["status", 'owner', "candidats", "electors", "organisation"])->where(["owner" => request()->user()->id, "visible" => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($vote, 'Tout les votes récupérés avec succès!!');
    }

    static function retrieveVotes($id)
    {
        $user = request()->user();
        if ($user->is_super_admin) { ### S'IL S'AGIT D'UN SUPER ADMIN
            ###il peut tout recuperer
            $vote =  Vote::with(["status", 'owner', "candidats", "electors", "organisation"])->where(["id" => $id])->get();
        } else {
            $vote = Vote::with(["status", 'owner', "candidats", "electors", "organisation"])->where(["owner" => request()->user()->id, "id" => $id, "visible" => 1])->get();
        }

        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        }
        return self::sendResponse($vote, "Vote récupéré(e) avec succès:!!");
    }

    static function updateVotes($request, $id)
    {
        $formData = $request->all();
        $user = request()->user();

        $vote = Vote::where(['id' => $id, 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        }

        $vote = $vote[0];

        #TRAITEMENT DU CHAMP **electors** S'IL EST renseigné PAR LE USER
        if ($request->get("electors")) {
            $electors_ids = $formData["electors"];
            // $electors_ids = explode(",", $electors_ids);
            foreach ($electors_ids as $id) {
                $elector = Elector::where(["id" => $id, "owner" => $user->id, "visible" => 1])->get();
                if ($elector->count() == 0) {
                    return self::sendError("L'electeur d'id :" . $id . " n'existe pas!", 404);
                }
            }

            #AFFECTATION DE L'ELECTEUR AU VOTE S'IL LE CHAMP EST RENSEIGNE PAR LE USER
            foreach ($electors_ids as $id) {
                $this_elector_vote = ElectorVote::where(["elector_id" => $id, "vote_id" => $vote->id])->get();
                #On verifie d'abord si ce attachement existait déjà 
                if ($this_elector_vote->count() == 0) {
                    $elector = Elector::where(["id" => $id, "owner" => $user->id, "visible" => 1])->get();
                    $vote->electors()->attach($elector);
                }
            }
        }

        #TRAITEMENT DU CHAMP **candidats** renseigné PAR LE USER
        if ($request->get("candidats")) {
            $candidats_ids = $formData["candidats"];
            // $candidats_ids = explode(",", $candidats_ids);
            foreach ($candidats_ids as $id) {
                $candidat = Candidat::where(["id" => $id, "owner" => $user->id, "visible" => 1])->get();
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
        $vote = Vote::where(['id' => $id, 'owner' => request()->user()->id, "visible" => 1])->get();
        if (count($vote) == 0) {
            return self::sendError("Ce Vote n'existe pas!", 404);
        };
        $vote = $vote[0];
        $vote->visible = 0;
        $vote->deleted_at = now();
        $vote->save();
        return self::sendResponse($vote, 'Ce Vote a été supprimé avec succès!');
    }

    static function AffectToElector($request)
    {
        $formData = $request->all();
        $elector = Elector::where(['id' => $formData['elector_id'], 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($elector->count() == 0) {
            return self::sendError("Ce electeur n'existe pas!", 404);
        };

        $vote = Vote::where(['id' => $formData['vote_id'], 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        };

        $vote = $vote[0];

        $this_elector_vote = ElectorVote::where(["elector_id" => $formData['elector_id'], "vote_id" => $vote->id])->get();
        #On verifie d'abord si ce attachement existait déjà 
        if ($this_elector_vote->count() == 0) { #Si ça n'existe pas, on le crée
            $vote->electors()->attach($elector);
        }

        #++====== ENVOIE D'SMS AU ELECTEUR +++++=======

        // $vote_url = env("BASE_URL") . "/vote/" . $elector[0]->identifiant . "/" . $elector[0]->secret_code . "/" . $vote->id;
        $message = "Vous avez été affecté.e au vote << " . $vote->name . " >> en tant qu'electeur sur e-voting";

        try {
            ##======ENVOIE D'SMS======##
            Send_SMS(
                $elector[0]->phone,
                $message,
            );

            #=====ENVOIE D'EMAIL =======~####
            Send_Email(
                $elector[0]->email,
                "Vous avez été affecté.e à un vote sur E-VOTING",
                $message,
            );
        } catch (\Throwable $th) {
            //throw $th;
        }

        return self::sendResponse($vote, "Affectation effectuée avec succès!");
    }

    static function retrieveElectorFromVote($request)
    {
        $formData = $request->all();
        $elector = Elector::where(['id' => $formData['elector_id'], 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($elector->count() == 0) {
            return self::sendError("Ce electeur n'existe pas!", 404);
        };

        $vote = Vote::where(['id' => $formData['vote_id'], 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        };

        $vote_elector = ElectorVote::where(["elector_id" => $formData['elector_id'], "vote_id" => $formData['vote_id']])->get();
        if ($vote_elector->count() == 0) {
            return self::sendError("Ce electeur n'a pas été affecté à ce vote", 505);
        }
        $vote_elector = $vote_elector[0];
        $vote_elector->delete();

        return self::sendResponse($vote, "Retriat effectué avec succès!");
    }

    static function retrieveCandidatFromVote($request)
    {
        $formData = $request->all();
        $candidat = Candidat::where(['id' => $formData['candidat_id'], 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($candidat->count() == 0) {
            return self::sendError("Ce candidat n'existe pas!", 404);
        };

        $vote = Vote::where(['id' => $formData['vote_id'], 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        };

        $vote_candidat = CandidatVote::where(["candidat_id" => $formData['candidat_id'], "vote_id" => $formData['vote_id']])->get();
        if ($vote_candidat->count() == 0) {
            return self::sendError("Ce candidat n'a pas été affecté à ce vote", 505);
        }
        $vote_candidat = $vote_candidat[0];
        $vote_candidat->delete();

        return self::sendResponse($vote, "Retrait effectué avec succès!");
    }

    function initiateVote($vote_id)
    {

        $user = request()->user();

        $vote = Vote::where(["id" => $vote_id, "owner" => $user->id, "visible" => 1])->get();
        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        };

        $vote = $vote[0];
        #VERIFIONS SI CE VOTE A DEJA ETE INITIER
        if ($vote->status == 2) {
            return self::sendError("Ce vote est déjà initié", 505);
        }

        $electors = $vote->electors;
        if (count($electors) == 0) {
            return self::sendError("Aucun electeur n'est associé à ce vote!", 404);
        }

        #CHANGEMENT DE STATUS DU VOTE
        $vote->status = 2;
        $vote->save();

        foreach ($electors as $elector) {
            $this_elector_vote = ElectorVote::where(["elector_id" => $elector->id, "vote_id" => $vote_id])->get();

            $this_elector_vote = $this_elector_vote[0];

            #===== ENVOIE D'SMS AUX ELECTEURS DU VOTE =======~####

            $vote_url = env("BASE_URL") . "/vote?id=" . $elector->identifiant . "&token=" . $this_elector_vote->secret_code;
            $message = "Le vote << " . $vote->name . " >> auquel vous avez été affecté.e viens d'etre initié! Cliquez ici pour voter: " . $vote_url;

            try {
                #===SMS====#
                Send_SMS(
                    $elector->phone,
                    $message
                );

                #=====ENVOIE D'EMAIL =======~####
                Send_Email(
                    $elector->email,
                    "Vous êtes appelé.e à un vote sur E-VOTING",
                    $message,
                );
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        return self::sendResponse($vote, "Vote initié avec succès!!");
    }

    function resendVote($vote_id)
    {
        $user = request()->user();
        $vote = Vote::where(["id" => $vote_id, "owner" => $user->id, "visible" => 1])->get();
        if ($vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        };

        $vote = $vote[0];
        #VERIFIONS SI CE VOTE A DEJA ETE INITIER
        if ($vote->status != 2) {
            return self::sendError("Ce vote n'est pas encore initié", 505);
        }

        $electors = $vote->electors;
        if (count($electors) == 0) {
            return self::sendError("Aucun electeur n'est associé à ce vote!", 404);
        }

        foreach ($electors as $elector) {
            $this_elector_vote = ElectorVote::where(["elector_id" => $elector->id, "vote_id" => $vote_id])->get();

            $this_elector_vote = $this_elector_vote[0];

            #===== ENVOIE D'SMS AUX ELECTEURS DU VOTE =======~####

            $vote_url = env("BASE_URL") . "/vote?id=" . $elector->identifiant . "&token=" . $this_elector_vote->secret_code;
            $message = "Le vote << " . $vote->name . " >> auquel vous avez été affecté.e viens d'etre initié! Cliquez ici pour voter: " . $vote_url;

            try {
                ##====ENVOIE D'SMS=====##
                Send_SMS(
                    $elector->phone,
                    $message
                );

                #=====ENVOIE D'EMAIL =======~####
                Send_Email(
                    $elector->email,
                    "Vous êtes appelé.e à un vote sur E-VOTING",
                    $message,
                );
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        return self::sendResponse($vote, "Vote renvoyé avec succès!!");
    }
}
