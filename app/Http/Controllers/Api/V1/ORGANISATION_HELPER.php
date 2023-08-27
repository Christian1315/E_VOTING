<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Organisation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ORGANISATION_HELPER extends BASE_HELPER
{
    ##======== ORGANISATION VALIDATION =======##
    static function organisation_rules(): array
    {
        return [
            'name' => ['required', Rule::unique('organisations')],
            'description' => ['required'],
            'img' => ['required'],
            'sigle' => ['required', Rule::unique('organisations')],
        ];
    }

    static function organisation_messages(): array
    {
        return [
            'name.required' => 'Le name est réquis!',
            'description.required' => 'La description est réquise!',
            'img.required' => 'L\'image est réquis!',
            'sigle.required' => 'Le sigle est réquis!',
            'sigle.unique' => 'Ce sigle existe déjà!',
        ];
    }

    static function Organisation_Validator($formDatas)
    {
        #
        $rules = self::organisation_rules();
        $messages = self::organisation_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function createOrganisation($request)
    {
        $formData = $request->all();
        ##GESTION DES FICHIERS
        $img = $request->file('img');
        $img_name = $img->getClientOriginalName();
        $request->file('img')->move("organisations", $img_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE **ORGANISATIONS**
        $formData["img"] = asset("organisations/" . $img_name);

        $organisation = Organisation::create($request->all()); #ENREGISTREMENT DE L'ORGANISATION DANS LA DB
        $organisation->owner = request()->user()->id;
        $organisation->img = $formData["img"];

        $organisation->save();
        return self::sendResponse($organisation, 'Organisation crée avec succès!!');
    }

    static function getOrganisations()
    {
        $organisations =  Organisation::where(["visible" => 1])->orderBy("id", "desc")->get();
        return self::sendResponse($organisations, 'Toutes les organisations récupérés avec succès!!');
    }

    static function retrieveOrganisations($id)
    {
        $organisation = Organisation::where(['id' => $id, "visible" => 1])->get();
        if ($organisation->count() == 0) {
            return self::sendError("Cette organisation n'existe pas!", 404);
        }
        return self::sendResponse($organisation, "Organisation récupéré(e) avec succès:!!");
    }

    static function updateOrganisations($request, $id)
    {
        $formData = $request->all();
        $organisation = Organisation::where(['id' => $id, 'owner' => request()->user()->id, "visible" => 1])->get();
        if ($organisation->count() == 0) {
            return self::sendError("Cette organisation n'existe pas!", 404);
        }

        #FILTRAGE POUR EVITER LES DOUBLONS
        if ($request->get("name")) {
            $name = Organisation::where(['name' => $formData['name'], 'owner' => request()->user()->id])->get();

            if (!count($name) == 0) {
                return self::sendError("Ce name existe déjà!!", 404);
            }
        }

        if ($request->get("sigle")) {
            $sigle = Organisation::where(['sigle' => $formData['sigle'], 'owner' => request()->user()->id])->get();

            if (!count($sigle) == 0) {
                return self::sendError("Ce sigle existe déjà!!", 404);
            }
        }

        ##GESTION DES FICHIERS
        if ($request->file("img")) {
            $img = $request->file('img');
            $img_name = $img->getClientOriginalName();
            $request->file('img')->move("organisations", $img_name);
            //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
            $formData["img"] = asset("pieces/" . $img_name);
        }
        $organisation = $organisation[0];
        $organisation->update($formData);
        return self::sendResponse($organisation, "Organisation récupéré(e) avec succès:!!");
    }

    static function organisationDelete($id)
    {
        $organisation = Organisation::where(['id' => $id, 'owner' => request()->user()->id, "visible" => 1])->get();
        if (count($organisation) == 0) {
            return self::sendError("Cette Organisation n'existe pas!", 404);
        };
        $organisation = $organisation[0];
        $organisation->visible = 0;
        $organisation->deleted_at = now();
        $organisation->save();
        return self::sendResponse($organisation, 'Cette Organisation a été supprimée avec succès!');
    }
}
