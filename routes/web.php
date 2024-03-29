<?php

use App\Http\Controllers\PdfController;
use App\Mail\SendEmail;
use App\Models\User;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/documentation', function () {
    return view('documentation');
});
Route::get("user/{id?}", function ($id = null) {
    return 'User ' . $id;
});

Route::get('pdf', [PdfController::class, 'getPostPdf']);

Route::get('/sendMail', function () {
    $user = [
        "subject" => "Inscription",
        "message" => "Here is the message",
    ];
    Mail::to("gogochristian009@gmail.com")->send(new SendEmail($user));
    dd("MESSAGE ENVOYE AVEC SUCCèS");
});

Route::get('/sendNotification', function () {
    $data = [
        "subject" => "TEST DE NOTIFICATION",
        "message" => "INSCRIS AVEC SUCCES SUR E-VOTING!",
    ];
    $user = User::find(4);
    Send_Notification(
        $user,
        "TEST DE NOTIFICATION",
        "INSCRIS AVEC SUCCES SUR E-VOTING!"
    );
    // return $user;
    // $notification = new SendNotification($data);
    // $notification->to($user->email);
    // Notification::send($user, new SendNotification($data));
    dd("NOTIFICATION ENVOYEE AVEC SUCCèS");
});
