<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Action;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ACTION_HELPER extends BASE_HELPER
{
    ##======== PROFIL VALIDATION =======##

    static function action_rules(): array
    {
        return [
            'name' => ['required', Rule::unique("actions")],
            'description' => ['required'],
        ];
    }

    static function action_messages(): array
    {
        return [
            'name.required' => 'Le champ name est réquis!',
            'name.unique' => 'Cette action existe déjà',
            'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Action_Validator($formDatas)
    {
        $rules = self::action_rules();
        $messages = self::action_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createAction($formData)
    {
        $action = Action::create($formData); #ENREGISTREMENT DE L'ACTION DANS LA DB
        return self::sendResponse($action, 'Action crée avec succès!!');
    }

    static function allActions()
    {
        $actions =  Action::with(['rights'])->orderBy('id', 'desc')->get();
        return self::sendResponse($actions, 'Tout les droits récupérés avec succès!!');
    }

    static function _retrieveAction($id)
    {
        $action = Action::with(['rights'])->where('id', $id)->get();
        if ($action->count() == 0) {
            return self::sendError("Cette action n'existe pas!", 404);
        }
        return self::sendResponse($action, "Action récupérée avec succès:!!");
    }

    static function _updateAction($formData, $id)
    {
        $action = Action::where('id', $id)->get();
        if (count($action) == 0) {
            return self::sendError("Cette action n'existe pas!", 404);
        };
        $action = Action::find($id);
        $action->update($formData);
        $action['rights'] = $action->rights;
        return self::sendResponse($action, 'Cette action a été modifié avec succès!');
    }

    static function actionDelete($id)
    {
        $action = Action::where('id', $id)->get();
        if (count($action) == 0) {
            return self::sendError("Cette action n'existe pas!", 404);
        };
        $action = Action::find($id);
        $action->delete();
        $action['users'] = $action->users;
        $action['rights'] = $action->rights;
        return self::sendResponse($action, 'Cette action a été supprimée avec succès!');
    }
}
