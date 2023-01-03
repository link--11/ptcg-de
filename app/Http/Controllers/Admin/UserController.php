<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function users()
    {
        $users = User::all();

        return view('admin.users', [
            'users' => $users
        ]);
    }

    // @todo ADMIN ONLY
    public function create(Request $request) {

        $user = User::create([
            'email' => $request->email
        ]);

        return Redirect::route('admin.user', [ 'id' => $user->id ]);
    }

    public function user(Request $request) {
        $user = User::find($request->route('id'));

        return view('admin.user', [
            'user' => $user
        ]);
    }

    public function update(Request $request) {
        $user = User::find($request->route('id'));

        $user->fill($request->all());
        $user->save();

        return Redirect::route('admin.user', [ 'id' => $user->id ])
            ->with('status', 'user-updated');
    }

}
