<?php

use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\UserController;
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

Route::view('/', 'home');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('admin')->group(function () {
    Route::get('/stores', [StoreController::class, 'stores'])->name('admin.stores');
    Route::post('/stores', [StoreController::class, 'create'])->name('admin.stores.create');
    Route::get('/stores/{id}', [StoreController::class, 'store'])->name('admin.store');
    Route::patch('/stores/{id}', [StoreController::class, 'update'])->name('admin.store.update');

    Route::get('/users', [UserController::class, 'users'])->name('admin.users');
    Route::post('/users', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('/users/{id}', [UserController::class, 'page'])->name('admin.user');
    Route::patch('/users/{id}', [UserController::class, 'update'])->name('admin.user.update');

    Route::get('/pages', [PageController::class, 'pages'])->name('admin.pages');
    Route::post('/pages', [PageController::class, 'create'])->name('admin.pages.create');
    Route::get('/pages/{id}', [PageController::class, 'page'])->name('admin.page');
    Route::patch('/pages/{id}', [PageController::class, 'update'])->name('admin.page.update');

})->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';

// if no route is matched check whether it's a post slug
Route::get('/{slug}', function (Request $request) {
    $slug = $request->route('slug');
    $page = Page::where('slug', $slug)->first();

    if (!$page) abort(404);

    return view('/page', [ 'page' => $page ]);
});
