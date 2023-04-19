<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Tournament;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function tournaments () {
        $tournaments = Tournament::where('date', '>', now())->get()->sortBy('date');

        return view('pages.tournaments', [
            'tournaments' => $tournaments
        ]);
    }

    public function tournament (Request $request) {
        $id = $request->route('id');
        $tournament = Tournament::find($id);

        return view('pages.tournament', [
            'tournament' => $tournament
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
        $store = Store::find($id);
        $tournaments = Tournament::where('date', '>', now())
            ->where('store_id', $id)
            ->get()->sortBy('date');

        return view('pages.store', [
            'store' => $store,
            'tournaments' => $tournaments
        ]);
    }

    public function results () {

        return view('pages.results', [

        ]);
    }
}
