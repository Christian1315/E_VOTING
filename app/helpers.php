<?php

use App\Mail\SendEmail;
use App\Models\Organisation;
use App\Models\Right;
use App\Models\User;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

function userCount()
{
    return count(User::all()) + 1;
}

function Custom_Timestamp()
{
    $date = new DateTimeImmutable();
    $micro = (int)$date->format('Uu'); // Timestamp in microseconds
    return $micro;
}

function Get_Username($user, $type)
{
    $created_date = $user->created_at;

    $year = explode("-", $created_date)[0]; ##RECUPERATION DES TROIS PREMIERS LETTRES DU USERNAME
    $an = substr($year, -2);

    $username =  $type . $an . userCount();
    return $username;
}

##Ce Helper permet de creér le passCode de réinitialisation de mot de passe
function Get_passCode($user, $type)
{
    $created_date = $user->created_at;

    $year = explode("-", $created_date)[0]; ##RECUPERATION DES TROIS PREMIERS LETTRES DU USERNAME
    $an = substr($year, -2);
    $timestamp = substr(Custom_Timestamp(), -3);

    $passcode =  $timestamp . $type . $an . userCount();
    return $passcode;
}

##======== CE HELPER PERMET D'ENVOYER DES SMS VIA PHONE ==========## 

function Login_To_Frik_SMS()
{
    $response = Http::post(env("SEND_SMS_API_URL") . "/api/v1/login", [
        "account" => "admin",
        "password" => "gogo@1315",
    ]);

    return $response;
}

function Send_SMS($phone, $message, $token=null)
{

    $response = Http::post(env("SEND_SMS_API_URL") . "/api/v1/sms/send_sms_from_other_plateforme", [
        "phone" => $phone,
        "message" => $message,
        "expediteur" => env("EXPEDITEUR"),
    ]);

    $response->getBody()->rewind();
}

function Send_Email($email, $subject, $message)
{
    $data = [
        "subject" => $subject,
        "message" => $message,
    ];
    Mail::to($email)->send(new SendEmail($data));
}

function Send_Notification($receiver, $subject, $message)
{
    $data = [
        "subject" => $subject,
        "message" => $message,
    ];
    Notification::send($receiver, new SendNotification($data));
}


##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN SUPER ADMIN OU PAS ==========## 
function Is_User_A_SUPER_ADMIN($userId)
{ #
    $user = User::where(['id' => $userId, 'is_super_admin' => 1])->get();
    if (count($user) == 0) {
        return false;
    }
    return true; #Sil est un Super Admin
}

##======== CE HELPER PERMET DE RECUPERER LES DROITS D'UN UTILISATEUR ==========## 
function User_Rights($rangId, $profilId)
{ #
    $rights = Right::with(["action", "profil", "rang"])->where(["rang" => $rangId, "profil" => $profilId])->get();
    return $rights;
}

##======== CE HELPER PERMET DE RECUPERER TOUTS LES DROITS PAR DEFAUT ==========## 
function All_Rights()
{ #
    $allrights = Right::with(["action", "profil", "rang"])->get();
    return $allrights;
}



function Get_User_Organisation($id)
{
    return Organisation::where("id", $id)->get();
}
