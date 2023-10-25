<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Elector;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ELECTOR_HELPER extends BASE_HELPER
{
    ##======== ELECTOR VALIDATION =======##
    static function elector_rules(): array
    {
        return [
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required', "email"],
        ];
    }

    static function elector_messages(): array
    {
        return [
            'name.required' => 'Le name est réquis!',
            'email.required' => 'L\'email est réquis!',
            'email.email' => 'Ce Champ est un mail!',
            'phone.required' => 'Le phone est réquis!',
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
            $organisationId = null;
            $organisation_name = "Super Admin";
        } else { #S'il sagit d'un simple admin
            $organisationId = $user->organisation; #RECUPEARATION DE L'ORGANISATION A LAQUELLE LE USER(admin ou super_admin) APPARTIENT
            $organisation = Organisation::find($organisationId);
            $organisation_name = $organisation->name;
        }

        $username =  Get_Username($user, $type); ##Get_Username est un helper qui genère le **username** 

        $userData = [
            "name" => $formData['name'],
            "username" => $username,
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "password" => $username,
            "organisation" => $organisationId,
        ];

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
        $message = "Vous avez été ajouté.e comme un electeur à l'organisation <<" . $organisation_name . ">> sur E-VOTING. Voici ci-dessous vos identifiants de connexion: Username:: " . $username;

        try {
            #===SMS====#
            Send_SMS(
                $formData['phone'],
                $message
            );

            #=====ENVOIE D'EMAIL =======~####
            Send_Email(
                $formData['email'],
                "Vous êtes electeur sur E-VOTING",
                $message,
            );
        } catch (\Throwable $th) {
            //throw $th;
        }

        return self::sendResponse($elector, 'Electeur crée avec succès!!');
    }

    static function getElectors()
    {
        $user = request()->user();
        if ($user->is_super_admin) { ###S'IL S'AGIT D'UN SUPER ADMIN
            ###il peut tout recuperer
            $elector =  Elector::with(['owner', "votes"])->orderBy("id", "desc")->get();
        } else {
            $elector =  Elector::with(['owner', "votes"])->where(["owner" => request()->user()->id, "visible" => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($elector, 'Tout les electeurs récupérés avec succès!!');
    }

    static function retrieveElectors($id)
    {
        $user = request()->user();
        if ($user->is_super_admin) { ### S'IL S'AGIT D'UN SUPER ADMIN
            ###il peut tout recuperer
            $elector =  Elector::with(['owner', "votes"])->where(["id" => $id])->orderBy("id", "desc")->get();
        } else {
            $elector =  Elector::with(['owner', "votes"])->where(["owner" => request()->user()->id, "visible" => 1])->orderBy("id", "desc")->get();
        }

        if ($elector->count() == 0) {
            return self::sendError("Ce elector n'existe pas!", 404);
        }
        return self::sendResponse($elector, "Elector récupéré(e) avec succès:!!");
    }

    static function updateElectors($request, $id)
    {
        $formData = $request->all();
        $elector = Elector::where(['id' => $id, 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($elector->count() == 0) {
            return self::sendError("Ce Elector n'existe pas!", 404);
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
        $elector->visible = 0;
        $elector->deleted_at = now();
        $elector->save();
        return self::sendResponse($elector, 'Ce electeur a été supprimé avec succès!');
    }
}
