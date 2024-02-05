<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActionController extends Controller
{
    public function register (Request $request) {
        $data = $request->input('data');
        $honey = $request->input('deck'); // hidden input field that should be empty (anti-bot)
        if (!$data || $honey) return [ 'ok' => false ];

        $check = [ [ 'playerid', $data['playerid'] ], [ 'tournament_id', $data['tournament_id'] ] ];
        if (Registration::where($check)->exists()) {
            return [ 'ok' => false, 'message' => 'Du bist bereits angemeldet!' ];
        }

        $code = Str::ulid();
        $data['code'] = $code;

        Registration::create($data);

        $tournament = Tournament::find($data['tournament_id']);

        send_confirmation_email($data, $tournament);

        $store_email = $tournament->store->email;
        if ($store_email) send_store_email($data, $tournament, $store_email);

        return [ 'ok' => true ];
    }

    public function registration (Request $request) {
        $code = $request->route('code');
        $registration = Registration::where('code', $code)->firstOrFail();
        $position = Registration::where([
            ['id', '<', $registration->id],
            ['tournament_id', '=', $registration->tournament_id]
        ])->count() + 1;

        return view('pages.registration', [
            'registration' => $registration,
            'position' => $position,
            'tournament' => $registration->tournament,
            'can_unregister' => can_unregister($registration->tournament)
        ]);
    }

    public function unregister (Request $request) {
        $code = $request->input('code');
        $registration = Registration::where('code', $code)->firstOrFail();

        if (can_unregister($registration->tournament)) {
            $registration->delete();
            return [ 'ok' => true ];
        } else {
            return [ 'ok' => false, 'message' => 'Abmeldung nicht mehr möglich.' ];
        }
    }
}

function can_unregister ($tournament) {
    $deadline = new \DateTime($tournament->date);
    $deadline->sub(new \DateInterval('P1D'));
    return (new \DateTime('now')) < $deadline;
}

function send_store_email ($data, $tournament, $to) {

    $type = __("pokemon.$tournament->type");
    $date = date_only($tournament->date);

    $subject = "Anmeldung $type $date - $data[first_name] $data[last_name]";

    $message = "Vorname: $data[first_name]\n";
    $message .= "Nachname: $data[last_name]\n";
    $message .= "Player ID: $data[playerid]\n";
    $message .= "Geburtsdatum: $data[birthdate]\n";
    $message .= "Email: $data[email]\n";

    $url = trim(explode('//', env('APP_URL'))[1], '/');

    $headers = "From: info@$url\n";
    $headers .= "Reply-To: $data[email]\n";

    mail($to, $subject, $message, $headers);
}

function send_confirmation_email ($data, $tournament) {
    $to = $data['email'];
    $type = __("pokemon.$tournament->type");
    $date = date_only($tournament->date);
    $store = $tournament->store;

    $subject = "Anmeldung $type $store[name] $store[city] $date";

    $url = trim(env('APP_URL'), '/');

    $message = "Deine Anmeldung mit folgenden Daten ist bei uns eingegangen.\n";
    $message .= "Name: $data[first_name] $data[last_name]\n";
    $message .= "Player ID: $data[playerid]\n\n";

    $message .= "Um deine Position auf der Anmeldeliste einzusehen, oder dich ggf. wieder abzumelden, benutze bitte folgenden Link:\n";
    $message .= "$url/anmeldung/$data[code]\n";

    $domain = explode('//', $url)[1];

    $headers = "From: info@$domain\n";

    $replyto = $store->email ?? "info@$domain";
    $headers .= "Reply-To: $replyto\n";

    mail($to, $subject, $message, $headers);
}
