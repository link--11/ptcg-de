<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Tournament;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class TournamentController extends Controller
{

    public function tournaments(Request $request)
    {
        $user = $request->user();

        if ($user->admin) {
            $tournaments = Tournament::all();
            $stores = Store::all(); // für dropdown zum erstellen neuer turniere

        } else {
            $stores = User::find($user->id)->stores()->get();
            $store_ids = $stores->map(fn ($store) => $store->id);
            $tournaments = Tournament::whereIn('store_id', $store_ids)->get();
        }

        $tournaments = $tournaments->sortByDesc('date');

        $now = new DateTime();

        $upcoming = $tournaments->filter(fn ($tour) => (new DateTime($tour->date)) > $now)->sortBy('date');
        $past = $tournaments->filter(fn ($tour) => (new DateTime($tour->date)) <= $now)->sortByDesc('date');

        return view('admin.tournaments', [
            'upcoming' => $upcoming,
            'past' => $past,
            'stores' => $stores
        ]);
    }

    public function create(Request $request) {
        $user = $request->user();

        // check if user is allowed to create tournament for the given store
        if (!$user->admin) {
            $store_ids = User::find($user->id)->stores()->get()->map(fn ($store) => $store->id);
            if (!in_array($request->input('store_id'), $store_ids->all())) abort(403);
        }

        $tournament = Tournament::create([
            'store_id' => $request->input('store_id'),
            'date' => $request->input('date'),
            'type' => $request->input('type')
        ]);

        return Redirect::route('admin.tournament', [ 'id' => $tournament->id ]);
    }

    // regular users can only edit the stores that they are assigned to
    function checkAuthorization ($request) {
        $tournament = Tournament::find($request->route('id'));
        $user = $request->user();
        $allowed = false;

        if ($user->admin) $allowed = true;
        else {
            $store_ids = User::find($user->id)->stores()->get()->map(fn ($store) => $store->id);
            if (in_array($tournament->store_id, $store_ids->all())) $allowed = true;
        }

        return [ $allowed, $tournament ];
    }

    public function tournament(Request $request) {
        list($allowed, $tournament) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        return view('admin.tournament', [
            'tournament' => $tournament,
            'store' => $tournament->store,
            'registrations' => $tournament->registrations
        ]);
    }

    public function update(Request $request) {
        list($allowed, $tournament) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        $tournament->fill($request->all());
        $tournament->save();

        return Redirect::route('admin.tournament', [ 'id' => $tournament->id ])
            ->with('status', 'tournament-updated');
    }

    public function destroy(Request $request) {
        list($allowed, $tournament) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        $tournament->delete();

        return Redirect::route('admin.tournaments')->with('status', 'tournament-deleted');
    }

}
