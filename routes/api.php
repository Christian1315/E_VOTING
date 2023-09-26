<?php

use App\Http\Controllers\Api\V1\ActionController;
use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\Authorization;
use App\Http\Controllers\Api\V1\CandidatController;
use App\Http\Controllers\Api\V1\ElectorController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\OrganisationController;
use App\Http\Controllers\Api\V1\ProfilController;
use App\Http\Controllers\Api\V1\RangController;
use App\Http\Controllers\Api\V1\RightController;
use App\Http\Controllers\Api\V1\VoteController;
use App\Http\Controllers\Api\V1\VoteStatusController;
use App\Http\Controllers\Api\V1\VoteAppController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {
    ###========== USERs ROUTINGS ========###
    Route::controller(UserController::class)->group(function () {
        Route::any('login', 'Login');
        Route::middleware(['auth:api'])->get('logout', 'Logout');
        Route::any('users', 'Users');
        Route::any('users/{id}', 'RetrieveUser');
        Route::any('user/{id}/update', 'UpdateUser');
        Route::any('{id}/password/update', 'UpdatePassword');
        Route::any('password/demand_reinitialize', 'DemandReinitializePassword');
        Route::any('password/reinitialize', 'ReinitializePassword');
        Route::any('{id}/delete', 'DeleteUser');
        Route::any('attach-user', 'AttachRightToUser'); #Attacher un droit au user 
        Route::any('desattach-user', 'DesAttachRightToUser'); #Attacher un droit au user 
    });
    Route::any('authorization', [Authorization::class, 'Authorization'])->name('authorization');

    ###========== Organisation ROUTINGS ========###
    Route::prefix('organisation')->group(function () {
        Route::controller(OrganisationController::class)->group(function () {
            Route::any('add', 'AddOrganisation');
            Route::any('all', 'Organisations');
            Route::any('{id}/retrieve', 'RetrieveOrganisation');
            Route::any('{id}/update', 'UpdateOrganisation');
            Route::any('{id}/delete', 'DeleteOrganisation');
        });
    });

    ###========== Admin ROUTINGS ========###
    Route::prefix('admin')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::any('add', 'AddAdmin');
            Route::any('all', 'getAdmins');
            Route::any('{id}/retrieve', 'retrieveAdmin');
            Route::any('{id}/update', 'updateAdmin');
            Route::any('{id}/delete', 'adminDelete');
        });
    });

    ###========== Candidats ROUTINGS ========###
    Route::prefix('candidat')->group(function () {
        Route::controller(CandidatController::class)->group(function () {
            Route::any('add', 'AddCandidat');
            Route::any('all', 'Candidats');
            Route::any('{id}/retrieve', 'RetrieveCandidat');
            Route::any('{id}/update', 'UpdateCandidat');
            Route::any('{id}/delete', 'DeleteCandidat');
        });
    });

    ###========== Electors ROUTINGS ========###
    Route::prefix('elector')->group(function () {
        Route::controller(ElectorController::class)->group(function () {
            Route::any('add', 'AddElector');
            Route::any('all', 'Electors');
            Route::any('{id}/retrieve', 'RetrieveElector');
            Route::any('{id}/update', 'UpdateElector');
            Route::any('{id}/delete', 'DeleteElector');
        });
    });

    ###========== Vote ROUTINGS ========###
    Route::prefix('vote')->group(function () {
        Route::controller(VoteController::class)->group(function () {
            Route::any('add', 'AddVote');
            Route::any('all', 'Votes');
            Route::any('{id}/retrieve', 'RetrieveVote');
            Route::any('{id}/update', 'UpdateVote');
            Route::any('{id}/delete', 'DeleteVote');
            Route::any('/affect-to-elector', '_AffectToElector');
            Route::any('/retrieve-from-elector', '_RetrieveElectorFromVote');
            Route::any('/retrieve-from-candidat', '_RetrieveCandidatFromVote');
            Route::any('{id}/initiate-a-vote', '_InitiateVote');
            Route::any('{id}/resend-a-vote', '_ResendVote');
        });
    });

    ###========== VOTE STATUS ROUTINGS ========###
    Route::prefix('voteStatus')->group(function () {
        Route::controller(VoteStatusController::class)->group(function () {
            Route::any('all', 'Status');
            Route::any('{id}/retrieve', '_RetrieveStatus');
        });
    });

    ###========== VOTE APP ROUTINGS ========###
    Route::prefix('voteApp')->group(function () {
        Route::controller(VoteAppController::class)->group(function () {
            Route::any('login', '_VoteAppLogin');
            Route::any('voteNow', '_VoteNow');
        });
    });


    ###========== RIGHTS ROUTINGS ========###
    Route::controller(RightController::class)->group(function () {
        Route::prefix('right')->group(function () {
            Route::any('add', 'CreateRight'); #AJOUT D'UN DROIT'
            Route::any('all', 'Rights'); #GET ALL RIGHTS
            Route::any('{id}/retrieve', 'RetrieveRight'); #RECUPERATION D'UN DROIT
            Route::any('{id}/update', '_UpdateRight'); #UPDATE D'UN DROIT
            Route::any('{id}/delete', 'DeleteRight'); #SUPPRESSION D'UN DROIT
        });
    });

    ###========== ACTION ROUTINGS ========###
    Route::controller(ActionController::class)->group(function () {
        Route::prefix('action')->group(function () {
            Route::any('add', 'CreateAction'); #AJOUT D'UNE ACTION'
            Route::any('all', 'Actions'); #GET ALL ACTIONS
            Route::any('{id}/retrieve', 'RetrieveAction'); #RECUPERATION D'UNE ACTION
            Route::any('{id}/delete', 'DeleteAction'); #SUPPRESSION D'UNE ACTION
            Route::any('{id}/update', 'UpdateAction'); #MODIFICATION D'UNE ACTION
        });
    });

    ###========== PROFILS ROUTINGS ========###
    Route::controller(ProfilController::class)->group(function () {
        Route::prefix('profil')->group(function () {
            Route::any('add', 'CreateProfil'); #AJOUT DE PROFIL
            Route::any('all', 'Profils'); #RECUPERATION DE TOUT LES PROFILS
            Route::any('{id}/retrieve', 'RetrieveProfil'); #RECUPERATION D'UN PROFIL
            Route::any('{id}/update', 'UpdateProfil'); #MODIFICATION D'UN PROFIL
            Route::any('{id}/delete', 'DeleteProfil'); #SUPPRESSION D'UN PROFIL
        });
    });

    ###========== RANG ROUTINGS ========###
    Route::controller(RangController::class)->group(function () {
        Route::prefix('rang')->group(function () {
            Route::any('add', 'CreateRang'); #AJOUT DE RANG
            Route::any('all', 'Rangs'); #RECUPERATION DE TOUT LES RANGS
            Route::any('{id}/retrieve', 'RetrieveRang'); #RECUPERATION D'UN RANG
            Route::any('{id}/delete', 'DeleteRang'); #SUPPRESSION D'UN RANG
            Route::any('{id}/update', 'UpdateRang'); #MODIFICATION D'UN RANG'
        });
    });
});
