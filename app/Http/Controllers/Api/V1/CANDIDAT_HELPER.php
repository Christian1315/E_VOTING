<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Candidat;
use App\Models\Organisation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CANDIDAT_HELPER extends BASE_HELPER
{
    ##======== CANDIDAT VALIDATION =======##
    static function candidat_rules(): array
    {
        return [
            'name' => ['required', Rule::unique('candidats')],
            'description' => ['required'],
            'img' => ['required'],
            'organisation' => ['required', "integer"],
        ];
    }

    static function candidat_messages(): array
    {
        return [
            'name.required' => 'Le name est réquis!',
            'email.required' => 'L\'email est réquis!',
            'email.unique' => 'L\'email existe déjà!',
            'email.email' => 'Ce Champ est un mail!',
            'phone.required' => 'Le phone est réquis!',
            'phone.unique' => 'Le phone est existe déjà!',
            'organisation.required' => 'L\'organisation est réquise!',
            'organisation.integer' => 'Ce champ est un entier!',
        ];
    }

    static function Candidat_Validator($formDatas)
    {
        #
        $rules = self::candidat_rules();
        $messages = self::candidat_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function createCandidat($request)
    {
        $formData = $request->all();
        #ON VERIFIER SI L'ORGANISATION EXISTE EN AU NOM DU USER QUI CREE LE CANDIDAT

        $user =  request()->user();

        if ($user->is_super_admin) { #S'IL EST UN SUPER ADMIN
            #ON VERIFIE JUSTE L'ORGANISATION VIA SON ID
            $organisation = Organisation::where(['id' => $formData['organisation']])->get();
            if ($organisation->count() == 0) {
                return self::sendError("Cette organisation n'existe pas!", 404);
            }
        } else { #S'IL N'EST PAS UN SUPER ADMIN
            #on verifie si l'organisation existe dans la DB
            $organisation = Organisation::where(['id' => $formData['organisation']])->get();
            if ($organisation->count() == 0) {
                return self::sendError("Cette organisation n'existe pas!", 404);
            }

            #ON SE RASSURE QU'IL A ETE AFFECTE A CETTE ORGANISATION
            $user_organisation_id = $user->organisation; #recuperation de l'ID de l'organisation affectée au user
            $organisation = Get_User_Organisation($user_organisation_id);
            // return $organisation->id;

            if ($organisation->count() == 0) {
                return self::sendError("Vous ne faites pas parti de cette organistion", 404);
            }

            $formData["organisation"] = $user_organisation_id;
        }


        ##GESTION DE L'IMAGE
        $img = $request->file('img');
        $img_name = $img->getClientOriginalName();
        $request->file('img')->move("candidats", $img_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE **CANDIDATS**
        $formData["img"] = asset("candidats/" . $img_name);

        ##ENREGISTREMENT DU CANDIDAT DANS LA DB
        $candidat = Candidat::create($formData);
        $candidat->owner = request()->user()->id;
        $candidat->img = $formData["img"];

        $candidat->save();
        return self::sendResponse($candidat, 'Candidat crée avec succès!!');
    }

    static function getCandidats()
    {
        $user = request()->user();
        if ($user->is_super_admin) { ###S'IL S'AGIT D'UN SUPER ADMIN
            ###il peut tout recuperer
            $candidat =  Candidat::with(['owner', 'belong_to_organisation', "votes"])->orderBy("id", "desc")->get();
        } else {
            $candidat =  Candidat::with(['owner', 'belong_to_organisation', "votes"])->where(["owner" => request()->user()->id, "visible" => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($candidat, 'Tout les candidats récupérés avec succès!!');
    }

    static function retrieveCandidats($id)
    {
        $user = request()->user();
        if ($user->is_super_admin) { ###S'IL S'AGIT D'UN SUPER ADMIN
            ###il peut tout recuperer
            $candidat =  Candidat::with(['owner', 'belong_to_organisation', "votes"])->orderBy("id", "desc")->get();
        } else {
            $candidat =  Candidat::with(['owner', 'belong_to_organisation', "votes"])->where(["owner" => request()->user()->id, "visible" => 1])->orderBy("id", "desc")->get();
        }
        $candidat = Candidat::with(['owner', 'belong_to_organisation', "votes"])->where(["owner" => request()->user()->id, "id" => $id, "visible" => 1])->get();
        if ($candidat->count() == 0) {
            return self::sendError("Ce Candidat n'existe pas!", 404);
        }
        return self::sendResponse($candidat, "Candidat récupéré(e) avec succès:!!");
    }

    static function updateCandidats($request, $id)
    {
        $user = request()->user();
        $formData = $request->all();
        $candidat = Candidat::where(["visible" => 1])->find($id);

        if ($candidat->count() == 0) {
            return self::sendError("Ce Candidat n'existe pas!", 404);
        }

        if ($candidat->owner != $user->id) {
            return self::sendError("Ce Candidat ne vous appartient pas!", 404);
        }

        if ($request->get("organisation")) {

            if ($user->is_super_admin) { #S'IL EST UN SUPER ADMIN
                #ON VERIFIE JUSTE L'ORGANISATION VIA SON ID
                $organisation = Organisation::where(['id' => $formData['organisation']])->get();
                if ($organisation->count() == 0) {
                    return self::sendError("Cette organisation n'existe pas!", 404);
                }
            } else { #S'IL N'EST PAS UN SUPER ADMIN
                #on verifie si l'organisation existe dans la DB
                $organisation = Organisation::find($formData['organisation']);
                if (!$organisation) {
                    return self::sendError("Cette organisation n'existe pas!", 404);
                }

                #ON SE RASSURE QU'IL A ETE AFFECTE A CETTE ORGANISATION
                $user_organisation_id = $user->organisation; #recuperation de l'ID de l'organisation affectée au user
                $this_admin_organisation = Get_User_Organisation($user_organisation_id);

                // return $user_organisation_id;

                if ($formData["organisation"] != $user_organisation_id) {
                    return self::sendError("Vous ne faites pas parti de cette organisation", 404);
                }
            }
        }

        ##GESTION DES FICHIERS
        if ($request->file("img")) {
            $img = $request->file('img');
            $img_name = $img->getClientOriginalName();
            $request->file('img')->move("candidats", $img_name);
            //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
            $formData["img"] = asset("candidats/" . $img_name);
        }
        $candidat->update($formData);
        return self::sendResponse($candidat, "Candidat modifié(e) avec succès:!!");
    }

    static function candidatDelete($id)
    {
        $user = request()->user();
        $candidat = Candidat::where(["visible" => 1])->find($id);
        if ($candidat->count() == 0) {
            return self::sendError("Ce Candidat n'existe pas!", 404);
        }

        if ($candidat->owner != $user->id) {
            return self::sendError("Ce Candidat ne vous appartient pas!", 404);
        }
        $candidat->visible = 0;
        $candidat->deleted_at = now();
        $candidat->save();
        return self::sendResponse($candidat, 'Cet Candidat a été supprimé avec succès!');
    }
}
