<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CandidatVote;
use App\Models\Elector;
use App\Models\ElectorVote;
use App\Models\Vote;
use Illuminate\Support\Facades\Validator;



class VOTE_APP_HELPER extends BASE_HELPER
{
    ##======== VOTE LOGIN VALIDATION =======##
    static function vote_app_rules(): array
    {
        return [
            'id' => ['required'],
            'secret_code' => ['required'],
        ];
    }

    static function vote_app_messages(): array
    {
        return [];
    }

    static function Vote_app_Validator($formDatas)
    {
        #
        $rules = self::vote_app_rules();
        $messages = self::vote_app_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }


    ##======== VOTE NOW VALIDATION =======##
    static function vote_Now_app_rules(): array
    {
        return [
            'id' => ['required'],
            'secret_code' => ['required'],
            'candidat_id' => ['required'],
        ];
    }

    static function vote_Now_app_messages(): array
    {
        return [];
    }

    static function Vote_Now_app_Validator($formDatas)
    {
        #
        $rules = self::vote_Now_app_rules();
        $messages = self::vote_Now_app_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function voteAppLogin($request)
    {
        $formData = $request->all();
        // return $formData;
        $elector_vote = ElectorVote::where(["secret_code" => $formData["secret_code"]])->get();

        $elector = Elector::where("identifiant", $formData["id"])->get();
        if ($elector->count() == 0) { #On vérifie s'il est un Electeur d'abord
            return self::sendError("Echec de connexion! Vous n'etes pas un electeur", 404);
        }

        #Verifie si l'electeur a déjà voter pour ce vote
        if ($elector_vote[0]->voted) {
            return self::sendError("Merci d'avoir déjà voter pour ce vote!", 404);
        }

        #on verifie s'il a été vraiment affecté.e à ce vote
        if ($elector_vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        }



        $vote_id = $elector_vote[0]->vote_id; #Recuperation de l'ID du vote
        $vote = Vote::where("id", $vote_id)->get(); #Recuperation du vote
        $vote = $vote[0];

        #RECUPERATION DU VOTE DE L'ELECTEUR
        $data["vote"] = $vote;
        $data["elector"] = $elector[0];
        $data["candidats"] = $vote->candidats;

        return self::sendResponse($data, "Vous etes authentifié avec succès!");
    }

    function voteNow($request)
    {
        $formData = $request->all();
        $elector_vote = ElectorVote::where(["secret_code" => $formData["secret_code"]])->get();

        #on verifie s'il a été vraiment affecté.e à ce vote
        if ($elector_vote->count() == 0) {
            return self::sendError("Ce vote n'existe pas!", 404);
        }

        $vote_id = $elector_vote[0]->vote_id; #Recuperation de l'ID du vote
        $vote = Vote::where("id", $vote_id)->get(); #Recuperation du vote
        $vote = $vote[0];

        #Verifie si l'electeur a déjà voter pour ce vote
        if ($elector_vote[0]->voted) {
            return self::sendError("Merci d'avoir déjà voter pour ce vote!", 404);
        }

        #S'il n'a pas encore voté, on lui permet de voter
        #(on change l'attribut **voited** de la la table **electors_votes** en true)
        $elector_vote[0]->voted = true;
        $elector_vote[0]->save();


        #Verifions si ce candidat corresponds à ce vote
        $candidat_vote = CandidatVote::where(["candidat_id" => $formData["candidat_id"], "vote_id" => $vote_id])->get();
        if ($candidat_vote->count() == 0) {
            return self::sendError("Ce Candidat ne corresponds pas à ce vote", 404);
        }

        #Passons à l'incrementation de la variable **score** du candidat dans la 
        #table **candidats_votes** pour notifier q'il vient d'etre voté par un electeur
        $candidat_vote = $candidat_vote[0];
        $candidat_vote_score = $candidat_vote->score + 1;
        $candidat_vote->score = $candidat_vote_score;
        $candidat_vote->save();

        return self::sendResponse($formData, "Votre votre a été éffectué avec succès!");
    }
}
