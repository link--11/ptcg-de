<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Tournament;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function tournaments () {
        $tournaments = Tournament::where('date', '>', now())->get()->sortBy('date');

        return view('tournaments', [
            'tournaments' => $tournaments
        ]);
    }

    public function registration () {
        $tournaments = Tournament::where('date', '>', now())->get()->sortBy('date');

        return view('registration', [
            'tournaments' => $tournaments
        ]);
    }

    public function stores () {
        $stores = Store::all();

        return view('stores', [
            'stores' => $stores
        ]);
    }

    public function results () {

        return view('results', [

        ]);
    }
}
