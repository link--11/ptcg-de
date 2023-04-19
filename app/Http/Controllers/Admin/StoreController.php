<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
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
            $stores = User::find($user->id)->stores()->get();
        }

        return view('admin.stores', [
            'user' => $user,
            'stores' => $stores
        ]);
    }

    // guarded by admin middleware in routes
    public function create(Request $request) {

        $store = Store::create([
            'name' => $request->name
        ]);

        return Redirect::route('admin.store', [ 'id' => $store->id ]);
    }

    // regular users can only edit the stores that they are assigned to
    function checkAuthorization ($request) {
        $store = Store::find($request->route('id'));
        $user = $request->user();
        $allowed = false;

        if ($user->admin) $allowed = true;
        else {
            $users = $store->users()->get();
            if ($users->filter(fn ($val) => $val->id === $user->id)->isNotEmpty()) {
                $allowed = true;
            }
        }

        return [ $allowed, $store ];
    }

    public function store(Request $request) {
        list($allowed, $store) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        return view('admin.store', [
            'store' => $store
        ]);
    }

    public function update(Request $request) {
        list($allowed, $store) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        $store->fill($request->all());
        $store->save();

        return Redirect::route('admin.store', [ 'id' => $store->id ])
            ->with('status', 'store-updated');
    }

    public function destroy(Request $request) {
        list($allowed, $store) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        $store->delete();

        return Redirect::route('admin.stores')->with('status', 'store-deleted');
    }

    public function upload(Request $request) {
        list($allowed, $store) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        $id = uniqid();

        $file_type = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

        $dir = public_path() . "/upload/stores/$store->id";
        if (!is_dir($dir)) mkdir($dir);
        $file = "$dir/$id.$file_type";

        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file);

        $store->picture = "$id.$file_type";
        $store->save();

        return Redirect::route('admin.store', [ 'id' => $store->id ])
            ->with('status', 'pic-updated');
    }

}
