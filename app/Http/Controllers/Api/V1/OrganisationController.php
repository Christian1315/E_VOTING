<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class OrganisationController extends ORGANISATION_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access']);
        $this->middleware("CheckSuperAdmin");
    }

    #AJOUT D'UNE ORGANISATION
    function AddOrganisation(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR ORGANISATION_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR ORGANISATION_HELPER
        $validator = $this->Organisation_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR ORGANISATION_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #ENREGISTREMENT DANS LA DB VIA **createOrganisation** DE LA CLASS BASE_HELPER HERITEE PAR ORGANISATION_HELPER
        return $this->createOrganisation($request);
    }

    #GET ALL ORGANISATIONS
    function Organisations(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR ORGANISATION_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DE TOUTES LES ORGANISATIONS
        return $this->getOrganisations();
    }

    #GET AN ORGANISATION
    function RetrieveOrganisation(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR ORGANISATION_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UNE ORGANISATION
        return $this->retrieveOrganisations($id);
    }

    #RECUPERER UNE ORGANISATION
    function UpdateOrganisation(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR ORGANISATION_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UNE ORGANISATION VIA SON **id**
        return $this->updateOrganisations($request, $id);
    }

    function DeleteOrganisation(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS ORGANISATION_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        return $this->organisationDelete($id);
    }
}
