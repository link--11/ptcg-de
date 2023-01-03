<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StoreController extends Controller
{

    public function stores(Request $request)
    {
        $user = $request->user();

        if ($user->admin) {
            $stores = Store::all();

        } else {
            $stores = [];
        }

        return view('admin.stores', [
            'user' => $user,
            'stores' => $stores
        ]);
    }

    // @todo ADMIN ONLY
    public function create(Request $request) {

        $store = Store::create([
            'name' => $request->name
        ]);

        return Redirect::route('admin.store', [ 'id' => $store->id ]);
    }

    public function store(Request $request) {
        $store = Store::find($request->route('id'));

        return view('admin.store', [
            'store' => $store
        ]);
    }

    public function update(Request $request) {
        $store = Store::find($request->route('id'));

        $store->fill($request->all());
        $store->save();

        return Redirect::route('admin.store', [ 'id' => $store->id ])
            ->with('status', 'store-updated');
    }

}
