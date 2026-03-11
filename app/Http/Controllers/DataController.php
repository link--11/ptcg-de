<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Tournament;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function tournaments (Request $request) {
        $type = $request->query('type');

        $tournaments = Tournament::query()
            ->where('date', '>', now())
            ->when($request->query('type'), function ($query, $type) {
                $query->where('type', $type);
            })
            ->orderBy('date')
            ->get();

        return view('pages.tournaments', [
            'tournaments' => $tournaments,
            'type' => $type
        ]);
    }

    public function tournament (Request $request) {
        $id = $request->route('id');
        $tournament = Tournament::findOrFail($id);

        $standings = [ 'MA' => [], 'SR' => [], 'JR' => [] ];
        if ($tournament->results) {
            foreach ($tournament->standings as $player) {
                $standings[$player->division][] = $player;
            }
        }

        return view('pages.tournament', [
            'tournament' => $tournament,
            'registrations' => $tournament->registrations->count(),
            'standings' => $standings,
            'photos' => $tournament->photos
        ]);
    }

    public function stores () {
        $stores = Store::all();

        return view('pages.stores', [
            'stores' => $stores
        ]);
    }

    public function store (Request $request) {
        $id = $request->route('id');
        $store = Store::findOrFail($id);
        $tournaments = Tournament::where('date', '>', now())
            ->where('store_id', $id)
            ->get()->sortBy('date');

        return view('pages.store', [
            'store' => $store,
            'tournaments' => $tournaments
        ]);
    }

    public function results () {
        $tournaments = Tournament::where('results', 1)->orderBy('date', 'desc')->get();

        return view('pages.results', [
            'tournaments' => $tournaments
        ]);
    }

    public function home () {
        $upcoming = Tournament::where('date', '>', now())->orderBy('date')->take(8)->get();
        $completed = Tournament::where('results', 1)->orderBy('date', 'desc')->take(8)->get();

        return view('home', [
            'upcoming' => $upcoming,
            'completed' => $completed
        ]);
    }
}
