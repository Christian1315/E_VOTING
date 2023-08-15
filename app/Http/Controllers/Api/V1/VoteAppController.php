<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class VoteAppController extends VOTE_APP_HELPER
{
    function _VoteAppLogin(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR VOTE_APP_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR VOTE_APP_HELPER
        $validator = $this->Vote_app_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR VOTE_APP_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        return $this->voteAppLogin($request);
    }

    function _VoteNow(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR VOTE_APP_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR VOTE_APP_HELPER
        $validator = $this->Vote_Now_app_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR VOTE_APP_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        return $this->voteNow($request);
    }
}
