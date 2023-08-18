<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class UserController extends USER_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access'])->except(["Login", "DemandReinitializePassword", "ReinitializePassword"]);
        $this->middleware("CheckSuperAdmin")->except(["Login", "DemandReinitializePassword", "ReinitializePassword"]);
    }
    #GET ALL USERS
    function Users(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR USER_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DE TOUT LES UTILISATEURS AVEC LEURS ROLES & TRANSPORTS
        return $this->getUsers();
    }

    #RECUPERER UN USER
    function RetrieveUser(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR USER_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN USER VIA SON **id**
        return $this->retrieveUsers($id);
    }

    #CONNEXION DU USER
    function Login(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS USER_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS USER_HELPER
        $validator = $this->Login_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS USER_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #AUTHENTIFICATION DU USER
        return $this->userAuthentification($request);
    }

    #MODIFIER UN PASSWORD
    function UpdatePassword(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR USER_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS USER_HELPER
        $validator = $this->NEW_PASSWORD_Validator($request->all());
        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS USER_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #RECUPERATION D'UN USER VIA SON **id**
        return $this->_updatePassword($request->all(), $id);
    }

    #DEMANDE DE REINITIALISATION D'UN PASSWORD
    function DemandReinitializePassword(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR USER_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN USER VIA SON **id**
        return $this->_demandReinitializePassword($request);
    }

    #REINITIALISER UN PASSWORD
    function ReinitializePassword(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR USER_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN USER VIA SON **id**
        return $this->_reinitializePassword($request);
    }

    function Logout(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS USER_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->userLogout($request);
    }
}
