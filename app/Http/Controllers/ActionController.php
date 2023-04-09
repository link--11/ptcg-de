<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Tournament;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function register (Request $request) {
        $data = $request->input('data');
        $honey = $request->input('deck'); // hidden input field that should be empty (anti-bot)
        if (!$data || $honey) return [ 'ok' => false ];

        Registration::create($data);

        $tournament = Tournament::find($data['tournament_id']);
        $email = $tournament->store->email;

        if ($email) send_email($data, $tournament, $email);

        return [ 'ok' => true ];
    }

}

function send_email ($data, $tournament, $to) {

    $type = __("pokemon.$tournament->type");
    $date = date_only($tournament->date);

    $subject = "Anmeldung $type $date - $data[name]";

    $message = "Name: $data[name]\n";
    $message .= "Player ID: $data[playerid]\n";
    $message .= "Geburtsdatum: $data[birthdate]\n";
    $message .= "Email: $data[email]\n";

    $url = trim(explode('//', env('APP_URL'))[1], '/');

    $headers = "From: info@$url\n";
    $headers .= "Reply-To: $data[email]\n";

    mail($to, $subject, $message, $headers);
}