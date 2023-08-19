<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Profil;
use Illuminate\Support\Facades\Validator;

class PROFIL_HELPER extends BASE_HELPER
{
    ##======== PROFIL VALIDATION =======##

    static function profil_rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
        ];
    }

    static function profil_messages(): array
    {
        return [
            'name.required' => 'Le champ name est réquis!',
            'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Profil_Validator($formDatas)
    {
        $rules = self::profil_rules();
        $messages = self::profil_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createProfil($formData)
    {
        $profil = Profil::create($formData); #ENREGISTREMENT DU PROFIL DANS LA DB

        return self::sendResponse($profil, 'Profil crée avec succès!!');
    }

    static function allProfils()
    {
        $profils =  Profil::with(['users'])->orderBy('id', 'desc')->get();
        return self::sendResponse($profils, 'Tout les profils récupérés avec succès!!');
    }

    static function _retrieveProfil($id)
    {
        $profil = Profil::with(['users'])->where('id', $id)->get();
        if ($profil->count() == 0) {
            return self::sendError("Ce profil n'existe pas!", 404);
        }
        return self::sendResponse($profil, "Profil récupéré avec succès:!!");
    }

    static function _updateProfil($formData, $id)
    {
        $profil = Profil::with(['users'])->where('id', $id)->get();
        if (count($profil) == 0) {
            return self::sendError("Ce profil n'existe pas!", 404);
        };
        $profil = Profil::with(['users'])->find($id);
        $profil->update($formData);
        return self::sendResponse($profil, 'Ce profil a été modifié avec succès!');
    }

    static function profilDelete($id)
    {
        $profil = Profil::where('id', $id)->get();
        if (count($profil) == 0) {
            return self::sendError("Ce profil n'existe pas!", 404);
        };
        $profil = Profil::with(['users'])->find($id);
        $profil->delete();
        return self::sendResponse($profil, 'Ce profil a été supprimé avec succès!');
    }
}
