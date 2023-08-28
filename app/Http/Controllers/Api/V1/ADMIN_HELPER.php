<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Admin;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ADMIN_HELPER extends BASE_HELPER
{
    ##======== ADMIN VALIDATION =======##
    static function admin_rules(): array
    {
        return [
            'name' => ['required', Rule::unique('users')],
            'email' => ['required', 'email', Rule::unique('users')],
            'phone' => ['required'],
            'organisation' => ['required', "integer"],
        ];
    }

    static function admin_messages(): array
    {
        return [
            'name.required' => 'Le name est réquis!',
            'email.required' => 'L\'email est réquis!',
            'email.unique' => 'L\'email existe déjà!',
            'email.email' => 'Ce Champ est un mail!',
            'phone.required' => 'Le phone est réquis!',
            'organisation.required' => 'L\'organisation est réquise!',
            'organisation.integer' => 'Ce champ est un entier!',
        ];
    }

    static function Admin_Validator($formDatas)
    {
        #
        $rules = self::admin_rules();
        $messages = self::admin_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function createAdmin($request)
    {
        $formData = $request->all();
        $organisation = Organisation::where(["id" => $formData["organisation"]])->get();

        if ($organisation->count() == 0) {
            return self::sendError("Cette organisation n'existe pas!", 404);
        }

        #SON ENREGISTREMENT EN TANT QU'UN USER

        $user = request()->user();
        $type = "ADM";

        $username =  Get_Username($user, $type); ##Add_Number est un helper qui genère le **number** 

        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $username)->get();
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
            "organisation" => $formData['organisation'],
            "profil_id" => 5, #UNE AGENCE
            "rang_id" => 2, #UN MODERATEUR
        ];

        // return $formData;
        $formData["username"] = $username;

        $user = User::create($userData);
        $user->is_admin = true;
        $user->owner = request()->user()->id;

        $user->save();
        // return request()->user()->id;
        ##ENREGISTREMENT DE L'ADMIN DANS LA DB
        $admin = Admin::create($formData);
        $admin->as_user = $user->id;
        $admin->owner = request()->user()->id;
        $admin->save();

        #=====ENVOIE D'SMS =======~####
        $sms_login =  Login_To_Frik_SMS();
        $message = "Votre compte admin a été crée avec succès sur E-VOTING. Voici ci-dessous vos identifiants de connexion: Username::" . $username;

        if ($sms_login['status']) {
            $token =  $sms_login['data']['token'];

            Send_SMS(
                $formData['phone'],
                $message,
                $token
            );
        }

        #=====ENVOIE D'EMAIL =======~####
        Send_Email(
            $formData['email'],
            "Inscription sur E-VOTING",
            $message,
        );
        return self::sendResponse($admin, 'Admin crée avec succès!!');
    }

    static function getAdmins()
    {
        $user = request()->user();
        if ($user->is_super_admin) { ###S'IL S'AGIT D'UN SUPER ADMIN
            ###il peut tout recuperer
            $admins =  Admin::with(['parent', 'owner', 'organisation'])->orderBy("id", "desc")->get();
        } else {
            $admins =  Admin::with(['parent', 'owner', 'organisation'])->where(["owner" => request()->user()->id, "visible" => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($admins, 'Tout les admins récupérés avec succès!!');
    }

    static function retrieveAdmins($id)
    {
        $user = request()->user();
        if ($user->is_super_admin) { ###S'IL S'AGIT D'UN SUPER ADMIN
            ###il peut tout recuperer
            $admin =  Admin::with(['parent', 'owner', 'organisation'])->where(["id" => $id])->get();
        } else {
            $admin = Admin::with(['parent', 'owner', 'organisation'])->where(["owner" => request()->user()->id, "id" => $id, "visible" => 1])->get();
        }
        if ($admin->count() == 0) {
            return self::sendError("Cet admin n'existe pas!", 404);
        }
        return self::sendResponse($admin, "Admin récupéré(e) avec succès:!!");
    }

    static function updateAdmins($request, $id)
    {
        $formData = $request->all();
        $admin = Admin::where(['id' => $id, 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($admin->count() == 0) {
            return self::sendError("Cet Admin n'existe pas!", 404);
        }

        #FILTRAGE POUR EVITER LES DOUBLONS
        if ($request->get("name")) {
            $name = Organisation::where(['name' => $formData['name'], 'owner' => request()->user()->id, "visible" => 1])->get();

            if (!count($name) == 0) {
                return self::sendError("Ce name existe déjà!!", 404);
            }
        }

        if ($request->get("sigle")) {
            $sigle = Organisation::where(['sigle' => $formData['sigle'], 'owner' => request()->user()->id, "visible" => 1])->get();

            if (!count($sigle) == 0) {
                return self::sendError("Ce sigle existe déjà!!", 404);
            }
        }

        ##GESTION DES FICHIERS
        if ($request->file("img")) {
            $img = $request->file('img');
            $img_name = $img->getClientOriginalName();
            $request->file('img')->move("organisations", $img_name);
            //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
            $formData["img"] = asset("pieces/" . $img_name);
        }
        $admin = $admin[0];
        $admin->update($formData);
        return self::sendResponse($admin, "Admin récupéré(e) avec succès:!!");
    }

    static function adminDelete($id)
    {
        $admin = Admin::where(['id' => $id, 'owner' => request()->user()->id, "visible" => 1])->get();
        if (count($admin) == 0) {
            return self::sendError("Cet admin n'existe pas!", 404);
        };
        $admin = $admin[0];
        $admin->visible = 0;
        $admin->deleted_at = now();
        $admin->save();
        return self::sendResponse($admin, 'Cet admin a été supprimé avec succès!');
    }
}
