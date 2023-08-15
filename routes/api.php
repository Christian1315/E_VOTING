<?php

use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\Authorization;
use App\Http\Controllers\Api\V1\CandidatController;
use App\Http\Controllers\Api\V1\ElectorController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\OrganisationController;
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
        Route::any('{id}/password/update', 'UpdatePassword');
        Route::any('{id}/delete', 'DeleteUser');
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
            Route::any('{id}/retrieve', 'retrieveAdmins');
            Route::any('{id}/update', 'updateAdmins');
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
        });
    });

    ###========== VOTE STATUS ROUTINGS ========###
    Route::prefix('VoteStatus')->group(function () {
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
});
