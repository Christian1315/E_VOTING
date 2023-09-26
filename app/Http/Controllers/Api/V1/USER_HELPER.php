<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Organisation;
use App\Models\Right;
use App\Models\User;
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

    ##======== ATTACH VALIDATION =======##
    static function ATTACH_rules(): array
    {
        return [
            'user_id' => 'required',
            'right_id' => 'required',
        ];
    }

    static function ATTACH_messages(): array
    {
        return [
            // 'user_id.required' => 'Veuillez renseigner soit votre username,votre phone ou soit votre email',
            // 'password.required' => 'Le champ Password est réquis!',
        ];
    }

    static function ATTACH_Validator($formDatas)
    {
        #
        $rules = self::ATTACH_rules();
        $messages = self::ATTACH_messages();

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
            $user['rang'] = $user->rang;
            $user['profil'] = $user->profil;
            // $user['rights'] = $user->rights;
            $user['token'] = $token;

            #renvoie des droits du user 
            $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés
            // return $attached_rights;

            if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
                if (Is_User_A_SUPER_ADMIN($user->id)) { #s'il est un admin
                    $user['rights'] = All_Rights();
                } else {
                    $user['rights'] = User_Rights($user->rang['id'], $user->profil['id']);
                }
            } else {
                $user['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
            }

            #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
            return self::sendResponse($user, 'Vous etes connecté(e) avec succès!!');
        }

        #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
        return self::sendError('Connexion échouée! Vérifiez vos données puis réessayez à nouveau!', 500);
    }

    static function getUsers()
    {
        $users =  User::with(["rang", "profil"])->where(["owner" => request()->user()->id])->get();

        foreach ($users as $user) {
            $user_organisation_id = $user->organisation;
            $user["belong_to_organisation"] = Get_User_Organisation($user_organisation_id);

            #renvoie des droits du user 
            $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés
            // return $attached_rights;

            if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
                if (Is_User_A_SUPER_ADMIN($user->id)) { #s'il est un admin
                    $user['rights'] = All_Rights();
                } else {
                    $user['rights'] = User_Rights($user->rang['id'], $user->profil['id']);
                }
            } else {
                $user['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
            }
        }
        return self::sendResponse($users, 'Touts les utilisatreurs récupérés avec succès!!');
    }

    static function retrieveUsers($id)
    {
        $user = User::where(['id' => $id, "owner" => request()->user()->id])->get();
        if ($user->count() == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        }

        $user = $user[0];
        $user_organisation_id = $user->organisation;
        $user["belong_to_organisation"] = Get_User_Organisation($user_organisation_id);

        #renvoie des droits du user 
        $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés
        // return $attached_rights;

        if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
            if (Is_User_A_SUPER_ADMIN($id)) { #s'il est un admin
                $user['rights'] = All_Rights();
                return "super_admin";
            } else {
                $user['rights'] = User_Rights($user->rang['id'], $user->profil['id']);
            }
        } else {
            $user['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
        }

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

    static function _updateUser($request)
    {
        $user = request()->user();
        $user = User::find($user->id);
        if (!$user) {
            return self::sendError("Ce compte ne vous appartient pas!", 404);
        };

        if ($request->get("name")) {
            $user->name = $request->get("name");
        }
        if ($request->get("username")) {
            $user->username = $request->get("username");
        }
        if ($request->get("phone")) {
            $user->phone = $request->get("phone");
        }
        if ($request->get("email")) {
            $user->email = $request->get("email");
        }
        if ($request->get("rang_id")) {
            $user->rang_id = $request->get("rang_id");
        }
        if ($request->get("profil_id")) {
            $user->profil_id = $request->get("profil_id");
        }
        if ($request->get("organisation")) {
            $organisation = Organisation::where(["owner" => $user->id])->find($request->get("organisation"));
            if (!$organisation) {
                return self::sendError("Cette Organisation n'existe pas!", 404);
            }
            $user->organisation = $request->get("organisation");
        }

        $user->save();
        return self::sendResponse($user, "Utilisateur modifié avec succès!!");
    }

    static function _demandReinitializePassword($request)
    {

        if (!$request->get("username")) {
            return self::sendError("Le Champ username est réquis!", 404);
        }
        $username = $request->get("username");

        $user = User::where(['username' => $username])->get();

        if (count($user) == 0) {
            return self::sendError("Ce compte n'existe pas!", 404);
        };

        #
        $user = $user[0];
        $pass_code = Get_passCode($user, "PASS");
        $user->pass_code = $pass_code;
        $user->pass_code_active = 1;
        $user->save();

        #===== ENVOIE D'SMS AUX ELECTEURS DU VOTE =======~####

        Send_Email(
            $user->email,
            "Demande de réinitialisation de password",
            "Demande de réinitialisation éffectuée avec succès! sur E-VOTING! Voici vos informations de réinitialisation de password ::" . $pass_code,
        );

        // $sms_login =  Login_To_Frik_SMS();

        // if ($sms_login['status']) {
        //     $token =  $sms_login['data']['token'];
        //     Send_SMS(
        //         $user->phone,
        //         "Demande de réinitialisation éffectuée avec succès! sur E-VOTING! Voici vos informations de réinitialisation de password ::" . $pass_code,
        //         $token
        //     );
        // }

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
            return self::sendError("Ce code n'est pas correct!", 404);
        };

        $user = $user[0];
        #Voyons si le passs_code envoyé par le user est actif
        if ($user->pass_code_active == 0) {
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

    static function rightAttach($formData)
    {
        $user = User::where(['id' => $formData['user_id'], 'owner' => request()->user()->id])->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };

        $right = Right::where('id', $formData['right_id'])->get();
        if (count($right) == 0) {
            return self::sendError("Ce right n'existe pas!", 404);
        };

        $user = User::find($formData['user_id']);
        $right = Right::find($formData['right_id']);

        $right->user_id = $user->id;
        $right->save();

        return self::sendResponse([], "User attaché au right avec succès!!");
    }

    static function rightDesAttach($formData)
    {
        $user = User::where(['id' => $formData['user_id'], 'owner' => request()->user()->id])->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };

        $right = Right::where('id', $formData['right_id'])->get();
        if (count($right) == 0) {
            return self::sendError("Ce right n'existe pas!", 404);
        };

        $user = User::find($formData['user_id']);
        $right = Right::find($formData['right_id']);

        $right->user_id = null;
        $right->save();

        return self::sendResponse([], "User Dettaché du right avec succès!!");
    }
}
