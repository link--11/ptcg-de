<?php

use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\TournamentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\DataController;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DataController::class, 'home'])->name('home');
Route::get('/ligen', [DataController::class, 'stores'])->name('stores');
Route::get('/ligen/{id}', [DataController::class, 'store'])->name('store');
Route::get('/turniere', [DataController::class, 'tournaments'])->name('tournaments');
Route::get('/turniere/{id}', [DataController::class, 'tournament'])->name('tournament');

Route::get('/ergebnisse', [DataController::class, 'results'])->name('results');

Route::post('/anmeldung', [ActionController::class, 'register'])->name('register');

Route::group([ 'prefix' => 'xyz', 'middleware' => [ 'auth' ] ],function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::group([ 'prefix' => 'xyz', 'middleware' => [ 'auth' ], 'as' => 'admin.' ], function () {
    Route::redirect('/', '/xyz/tournaments');

    Route::get('/stores', [StoreController::class, 'stores'])->name('stores');
    Route::get('/stores/{id}', [StoreController::class, 'store'])->name('store');
    Route::patch('/stores/{id}', [StoreController::class, 'update'])->name('store.update');

    Route::post('/stores/{id}/pic', [StoreController::class, 'upload'])->name('store.picture');

    Route::get('/tournaments', [TournamentController::class, 'tournaments'])->name('tournaments');
    Route::post('/tournaments', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::get('/tournaments/{id}', [TournamentController::class, 'tournament'])->name('tournament');
    Route::patch('/tournaments/{id}', [TournamentController::class, 'update'])->name('tournament.update');
    Route::delete('/tournaments/{id}', [TournamentController::class, 'destroy'])->name('tournament.delete');

    Route::middleware('admin')->group(function () {
        Route::post('/stores', [StoreController::class, 'create'])->name('stores.create');

        Route::get('/users', [UserController::class, 'users'])->name('users');
        Route::post('/users', [UserController::class, 'create'])->name('users.create');
        Route::get('/users/{id}', [UserController::class, 'user'])->name('user');
        Route::patch('/users/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('/users/{id}/attach', [UserController::class, 'attach'])->name('user.attach');
        Route::post('/users/{id}/detach', [UserController::class, 'detach'])->name('user.detach');

        Route::get('/pages', [PageController::class, 'pages'])->name('pages');
        Route::post('/pages', [PageController::class, 'create'])->name('pages.create');
        Route::get('/pages/{id}', [PageController::class, 'page'])->name('page');
        Route::patch('/pages/{id}', [PageController::class, 'update'])->name('page.update');
        Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('page.delete');
    });

});

require __DIR__.'/auth.php';

// if no route is matched check whether it's a post slug
Route::get('/{slug}', function (Request $request) {
    $slug = $request->route('slug');
    $page = Page::where('slug', $slug)->first();

    if (!$page) abort(404);

    return view('pages.page', [ 'page' => $page ]);
});
