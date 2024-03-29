<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    public function users()
    {
        $users = User::all();

        return view('admin.users', [
            'users' => $users
        ]);
    }

    public function create(Request $request) {

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return Redirect::route('admin.user', [ 'id' => $user->id ]);
    }

    public function user(Request $request) {
        $user = User::find($request->route('id'));

        $user_stores = $user->stores->map(fn ($store) => $store->id)->all();
        $stores = Store::all()->filter(fn ($store) => !in_array($store->id, $user_stores));

        return view('admin.user', [
            'user' => $user,
            'stores' => $stores
        ]);
    }

    public function update(Request $request) {
        $user = User::find($request->route('id'));

        $user->fill($request->all());
        $user->save();

        return Redirect::route('admin.user', [ 'id' => $user->id ])
            ->with('status', 'user-updated');
    }

    public function attach(Request $request) {
        $user = User::find($request->route('id'));

        $user->stores()->attach($request->input('store_id'));

        return Redirect::route('admin.user', [ 'id' => $user->id ])
                    ->with('status', 'stores-updated');
    }

    public function detach(Request $request) {
        $user = User::find($request->route('id'));

        $user->stores()->detach($request->input('store_id'));

        return Redirect::route('admin.user', [ 'id' => $user->id ])
                    ->with('status', 'stores-updated');
    }

    // public function destroy(Request $request) {
    //     $user = User::find($request->route('id'));
    //     $user->delete();
    // }

}
