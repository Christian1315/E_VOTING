<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Profil;
use App\Models\Rang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RANG_HELPER extends BASE_HELPER
{
    ##======== PROFIL VALIDATION =======##

    static function rang_rules(): array
    {
        return [
            'name' => ['required', Rule::unique('rangs')],
            'description' => ['required'],
        ];
    }

    static function rang_messages(): array
    {
        return [
            'name.required' => 'Le champ name est réquis!',
            'name.unique' => 'Ce rang existe déjà!',
            'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Rang_Validator($formDatas)
    {
        $rules = self::rang_rules();
        $messages = self::rang_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createRang($formData)
    {
        $rang = Rang::create($formData); #ENREGISTREMENT DU RANG DANS LA DB
        $rang['users'] = $rang->users();

        return self::sendResponse($rang, 'Rang crée avec succès!!');
    }

    static function allRangs()
    {
        $rangs =  Rang::with(['users'])->latest()->get();
        return self::sendResponse($rangs, 'Tout les rangs récupérés avec succès!!');
    }

    static function _retrieveRang($id)
    {
        $rang = Rang::with(['users'])->where('id', $id)->get();
        if ($rang->count() == 0) {
            return self::sendError("Ce rang n'existe pas!", 404);
        }
        return self::sendResponse($rang, "Rang récupéré avec succès:!!");
    }

    static function _updateRang($formData, $id)
    {
        $rang = Rang::where('id', $id)->get();
        if (count($rang) == 0) {
            return self::sendError("Ce rang n'existe pas!", 404);
        };
        $rang = Rang::find($id);
        $rang->update($formData);
        $rang['users'] = $rang->users;
        return self::sendResponse($rang, 'Ce rang a été modifié avec succès!');
    }

    static function rangDelete($id)
    {
        $rang = Rang::where('id', $id)->get();
        if (count($rang) == 0) {
            return self::sendError("Ce rang n'existe pas!", 404);
        };
        $rang = Rang::find($id);
        $rang->delete();
        $rang['users'] = $rang->users;
        return self::sendResponse($rang, 'Ce rang a été supprimé avec succès!');
    }
}
