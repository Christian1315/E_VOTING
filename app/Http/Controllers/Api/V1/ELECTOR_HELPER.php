<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Candidat;
use App\Models\Elector;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ELECTOR_HELPER extends BASE_HELPER
{
    ##======== ELECTOR VALIDATION =======##
    static function elector_rules(): array
    {
        return [
            'name' => ['required', Rule::unique('electors')],
            'phone' => ['required', Rule::unique("electors")],
            'email' => ['required', "email", Rule::unique("electors")],
        ];
    }

    static function elector_messages(): array
    {
        return [
            'name.required' => 'Le name est réquis!',
            'email.required' => 'L\'email est réquis!',
            'email.unique' => 'L\'email existe déjà!',
            'email.email' => 'Ce Champ est un mail!',
            'phone.required' => 'Le phone est réquis!',
            'phone.unique' => 'Le phone est existe déjà!',
        ];
    }

    static function Elector_Validator($formDatas)
    {
        #
        $rules = self::elector_rules();
        $messages = self::elector_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function createElector($request)
    {
        $formData = $request->all();
        $secret_code = Str::uuid();

        #SON ENREGISTREMENT EN TANT QU'UN USER

        $user = request()->user();
        $type = "ELEC";

        #Detection de l'organisation
        if ($user->is_super_admin) { #S'il sagit d'un super_admin
            $organisation = null;
            $organisationId = null;
        } else { #S'il sagit d'un simple admin
            $organisation = $user->organisation; #RECUPEARATION DE L'ORGANISATION A LAQUELLE LE USER(admin ou super_admin) APPARTIENT
            $organisationId = $organisation->id;
        }


        $username =  Get_Username($user, $type); ##Get_Username est un helper qui genère le **username** 

        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("phone", $formData['phone'])->get();
        if (count($user) != 0) {
            return self::sendError("Un compte existe déjà au nom de ce identifiant!", 404);
        }
        $user = User::where("email", $formData['email'])->get();
        if (count($user) != 0) {
            return self::sendError("Un compte existe déjà au nom de ce identifiant!!", 404);
        }

        $userData = [
            "name" => $formData['name'],
            "username" => $username,
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "password" => $username,
            "organisation" => $organisationId,
        ];

        // return $formData;
        $formData["username"] = $username;

        $user = User::create($userData);

        ##ENREGISTREMENT DE L'ELECTEUR DANS LA DB
        $elector = Elector::create($formData);
        $elector->as_user = $user->id;
        $elector->owner = request()->user()->id;
        $elector->secret_code = $secret_code;
        $elector->identifiant = $username;
        $elector->save();

        #=====ENVOIE D'SMS A L'ELECTEUR APRES CREATION DE SON COMPTE USER =======~####
        $sms_login =  Login_To_Frik_SMS();

        if ($sms_login['status']) {
            $token =  $sms_login['data']['token'];

            Send_SMS(
                $formData['phone'],
                "Votre compte Utilisateur a été crée avec succès sur E-VOTING. Voici ci-dessous vos identifiants de connexion: Username::" . $username,
                $token
            );
        }

        return self::sendResponse($elector, 'Electeur crée avec succès!!');
    }

    static function getElectors()
    {
        $elector =  Elector::with(['owner', "votes"])->where(["owner" => request()->user()->id])->orderBy("id", "desc")->get();
        return self::sendResponse($elector, 'Tout les electeurs récupérés avec succès!!');
    }

    static function retrieveElectors($id)
    {
        $elector = Elector::with(['owner', "votes"])->where(["owner" => request()->user()->id, "id" => $id])->get();
        if ($elector->count() == 0) {
            return self::sendError("Ce elector n'existe pas!", 404);
        }
        return self::sendResponse($elector, "Elector récupéré(e) avec succès:!!");
    }

    static function updateElectors($request, $id)
    {
        $formData = $request->all();
        $elector = Elector::where(['id' => $id, 'owner' => request()->user()->id])->get();
        if ($elector->count() == 0) {
            return self::sendError("Ce Elector n'existe pas!", 404);
        }

        #FILTRAGE POUR EVITER LES DOUBLONS
        if ($request->get("name")) {
            $name = Elector::where(['name' => $formData['name'], 'owner' => request()->user()->id])->get();

            if (!count($name) == 0) {
                return self::sendError("Ce name existe déjà!!", 404);
            }
        }

        $elector = $elector[0];
        $elector->update($formData);
        return self::sendResponse($elector, "Electeur modifié(e) avec succès:!!");
    }

    static function electorDelete($id)
    {
        $elector = Elector::where(['id' => $id, 'owner' => request()->user()->id])->get();
        if (count($elector) == 0) {
            return self::sendError("Ce Electeur n'existe pas!", 404);
        };
        $elector = $elector[0];
        $elector->delete();
        return self::sendResponse($elector, 'Ce electeur a été supprimé avec succès!');
    }
}
