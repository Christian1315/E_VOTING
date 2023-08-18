<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class USER_HELPER extends BASE_HELPER
{
    ##======== REGISTER VALIDATION =======##
    static function register_rules(): array
    {
        return [
            'account' => 'required',
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', Rule::unique('users')],
        ];
    }

    static function register_messages(): array
    {
        return [
            'account.required' => 'Le champ username est réquis!',
            'email.required' => 'Le champ Email est réquis!',
            'email.email' => 'Ce champ est un mail!',
            'email.unique' => 'Ce mail existe déjà!',
            'password.required' => 'Le champ Password est réquis!',
        ];
    }

    static function Register_Validator($formDatas)
    {
        #
        $rules = self::register_rules();
        $messages = self::register_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function createUser($formData)
    {
        $formData['password'] = Hash::make($formData['password']); #Hashing du password
        $user = User::create($formData); #ENREGISTREMENT DU USER DANS LA DB
        return self::sendResponse($user, 'User crée avec succès!!');
    }

    ##======== LOGIN VALIDATION =======##
    static function login_rules(): array
    {
        return [
            'account' => 'required',
            'password' => 'required',
        ];
    }

    static function login_messages(): array
    {
        return [
            'account.required' => 'Le champ Username est réquis!',
            'password.required' => 'Le champ Password est réquis!',
        ];
    }

    static function Login_Validator($formDatas)
    {
        #
        $rules = self::login_rules();
        $messages = self::login_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##======== NEW PASSWORD VALIDATION =======##
    static function NEW_PASSWORD_rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required',
        ];
    }

    static function NEW_PASSWORD_messages(): array
    {
        return [
            // 'new_password.required' => 'Veuillez renseigner soit votre username,votre phone ou soit votre email',
            // 'password.required' => 'Le champ Password est réquis!',
        ];
    }

    static function NEW_PASSWORD_Validator($formDatas)
    {
        #
        $rules = self::NEW_PASSWORD_rules();
        $messages = self::NEW_PASSWORD_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }


    static function userAuthentification($request)
    {
        if (is_numeric($request->get('account'))) {
            $credentials  =  ['phone' => $request->get('account'), 'password' => $request->get('password')];
            // $user = User::where(["phone" => $request->get('account')])->get();
        } elseif (filter_var($request->get('account'), FILTER_VALIDATE_EMAIL)) {
            $credentials  =  ['email' => $request->get('account'), 'password' => $request->get('password')];
            // $user = User::where(["email" => $request->get('account')])->get();
        } else {
            $credentials  =  ['username' => $request->get('account'), 'password' => $request->get('password')];
            // $user = User::where(["username" => $request->get('account')])->get();
        }

        if (Auth::attempt($credentials)) { #SI LE USER EST AUTHENTIFIE
            $user = Auth::user();
            $token = $user->createToken('MyToken', ['api-access'])->accessToken;
            $user['token'] = $token;

            #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
            return self::sendResponse($user, 'Vous etes connecté(e) avec succès!!');
        }

        #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
        return self::sendError('Connexion échouée! Vérifiez vos données puis réessayez à nouveau!', 500);
    }

    static function getUsers()
    {
        $users =  User::all();

        foreach ($users as $user) {
            $user_organisation_id = $user->organisation;
            $user["belong_to_organisation"] = Get_User_Organisation($user_organisation_id);
        }
        return self::sendResponse($users, 'Touts les utilisatreurs récupérés avec succès!!');
    }

    static function retrieveUsers($id)
    {
        $user = User::with(["my_admins"])->where('id', $id)->get();
        if ($user->count() == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        }

        $user = $user[0];
        $user_organisation_id = $user->organisation;
        $user["belong_to_organisation"] = Get_User_Organisation($user_organisation_id);
        return self::sendResponse($user, "Utilisateur récupéré(e) avec succès:!!");
    }

    static function _updatePassword($formData, $id)
    {
        $user = User::where(['id' => $id])->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };

        if (Hash::check($formData["old_password"], $user[0]->password)) { #SI LE old_password correspond au password du user dans la DB
            $user[0]->update(["password" => $formData["new_password"]]);
            return self::sendResponse($user, 'Mot de passe modifié avec succès!');
        }
        return self::sendError("Votre mot de passe est incorrect", 505);
    }

    static function _demandReinitializePassword($request)
    {

        if (!$request->get("username")) {
            return self::sendError("Le Champ username est réquis!", 404);
        }
        $username = $request->get("username");

        $user = User::where(['username' => $username])->get();

        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };

        #
        $user = $user[0];
        $pass_code = Get_Username($user, "PASS");
        $user->pass_code = $pass_code;
        $user->save();

        #===== ENVOIE D'SMS AUX ELECTEURS DU VOTE =======~####

        $sms_login =  Login_To_Frik_SMS();

        if ($sms_login['status']) {
            $token =  $sms_login['data']['token'];
            Send_SMS(
                $user->phone,
                "Demande de réinitialisation éffectuée avec succès! sur E-VOTING! Voici vos informations de réinitialisation de password ::" . $pass_code,
                $token
            );
        }

        return self::sendResponse($user, "Demande de réinitialisation éffectuée avec succès! Veuillez vous connecter avec le code qui vous a été envoyé par phone ");
    }

    static function _reinitializePassword($request)
    {

        $pass_code = $request->get("pass_code");

        if (!$pass_code) {
            return self::sendError("Ce Champ pass_code est réquis!", 404);
        }

        $new_password = $request->get("new_password");

        if (!$new_password) {
            return self::sendError("Ce Champ new_password est réquis!", 404);
        }


        $user = User::where(['pass_code' => $pass_code])->get();

        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };


        $user = $user[0];
        #Voyons si le passs_code envoyé par le user est actif
        if ($user->pass_code_active==0) {
            return self::sendError("Ce Code a déjà été utilisé une fois!Veuillez faire une autre demande de réinitialisation", 404);
        }

        #UPDATE DU PASSWORD
        $user->update(['password' => $new_password]);

        #SIGNALONS QUE CE pass_code EST D2J0 UTILISE
        $user->pass_code_active = 0;
        $user->save();


        #===== ENVOIE D'SMS AUX ELECTEURS DU VOTE =======~####

        $sms_login =  Login_To_Frik_SMS();

        if ($sms_login['status']) {
            $token =  $sms_login['data']['token'];
            Send_SMS(
                $user->phone,
                "Réinitialisation de password éffectuée avec succès sur E-VOTING!",
                $token
            );
        }

        return self::sendResponse($user, "Réinitialisation éffectuée avec succès!");
    }


    static function userLogout($request)
    {
        $request->user()->token()->revoke();
        // DELETING ALL TOKENS REMOVED
        // Artisan::call('passport:purge');
        return self::sendResponse([], 'Vous etes déconnecté(e) avec succès!');
    }
}
