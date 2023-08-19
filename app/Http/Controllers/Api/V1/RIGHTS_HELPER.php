<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Action;
use App\Models\Profil;
use App\Models\Rang;
use App\Models\Right;
use Illuminate\Support\Facades\Validator;

class RIGHTS_HELPER extends BASE_HELPER
{
    ##======== RIGHT VALIDATION =======##

    static function right_rules(): array
    {
        return [
            'module' => ['required', 'integer'],
            'action' => ['required', 'integer'],
            'rang' => ['required', 'integer'],
            'profil' => ['required', 'integer'],
            'description' => ['required'],
        ];
    }

    static function right_messages(): array
    {
        return [
            // 'label.required' => 'Le champ name est réquis!',
            // 'label.unique' => 'Ce droit existe déjà',
            // 'profil_id.required' => 'Le champ profil_id est réquis!',
            // 'action_id.required' => 'Le champ action_id est réquis!',
            // 'rang_id.required' => 'Le champ rand_id est réquis!',
        ];
    }

    static function Right_Validator($formDatas)
    {
        $rules = self::right_rules();
        $messages = self::right_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createRight($formData)
    {
        $action = Action::where('id', $formData['action'])->get();
        $profil = Profil::where('id', $formData['profil'])->get();
        $rang = Rang::where('id', $formData['rang'])->get();

        if (count($action) == 0) {
            return self::sendError("Cette action n'existe pas!!", 404);
        }
        if (count($profil) == 0) {
            return self::sendError("Ce profil n'existe pas!!", 404);
        }
        if (count($rang) == 0) {
            return self::sendError("Ce rang n'existe pas!!", 404);
        }

        #CREATION DU DROIT
        $right = Right::create($formData); #ENREGISTREMENT DU DROIT DANS LA DB

        $right['action'] = $right->action;
        $right['profil'] = $right->profil;
        $right['rang'] = $right->rang;

        $right = Right::with(["action", "profil", "rang"])->where("id", $right->id)->get();
        return self::sendResponse($right, 'Right crée avec succès!!');
    }

    static function allRights()
    {
        $rights =  Right::with(['action', 'profil', 'rang'])->orderBy('id', 'desc')->get();
        return self::sendResponse($rights, 'Tout les droits récupérés avec succès!!');
    }

    static function _retrieveRight($id)
    {
        $right = Right::with(['action', "profil", "rang"])->where('id', $id)->get();
        if ($right->count() == 0) {
            return self::sendError("Ce droit n'existe pas!", 404);
        }
        return self::sendResponse($right, "Droit récupéré avec succès:!!");
    }

    static function rightDelete($id)
    {
        $right = Right::where('id', $id)->get();
        if (count($right) == 0) {
            return self::sendError("Ce droit n'existe pas!", 404);
        };
        $right = Right::find($id);
        $right->delete();
        // $right['actions'] = $right->actions;
        return self::sendResponse($right, 'Ce droit a été supprimée avec succès!');
    }
}
