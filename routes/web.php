<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Ini halaman pertama yang diakses, masuk ke login karna ini halaman admin
Route::get('/', function () {
    return redirect()->route('login.index');
});

// Ini middleware auth ngejaga kalo belum login gabakal bisa masuk ke halaman itu

Route::middleware('auth')->controller(DashboardController::class)->group(function () {
    Route::get('dashboard', 'index')->name('dashboard.index');
});


// Ini buat routes user
Route::middleware('auth')->controller(UserController::class)->group(function () {
    Route::get('user', 'index')->name('user');
    Route::get('fetchUser', 'fetchUser')->name('user.fetch');
    Route::post('user', 'store')->name('user.store');
    Route::get('user/edit', 'edit')->name('user.edit');
    Route::post('user/edit', 'update')->name('user.update');
    Route::post('user/destroy', 'destroy')->name('user.destroy');
    Route::post('user/destroy/selected', 'destroySelected')->name('user.destroySelected');
});

Route::middleware('auth')->controller(FoodsController::class)->group(function () {
    Route::get('foods', 'index')->name('foods');
    Route::post('foods', 'store')->name('foods.store');
    Route::get('foods/edit', 'edit')->name('foods.edit');
    Route::post('foods/edit', 'update')->name('foods.update');
    Route::get('fetchFoods', 'fetchFoods')->name('foods.fetch');
    Route::post('foods/destroy', 'destroy')->name('foods.destroy');
    Route::post('foods/destroy/selected', 'destroySelected')->name('foods.destroySelected');
});


//Auth Login
Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'index')->name('login.index');
    Route::post('login', 'store')->name('login.store');
    Route::post('logout', 'logout')->name('logout');
});

//route error
// Kalo bukan admin gabakal bisa akses
Route::get('403', function () {
    return view('errors.403');
})->name('error.403');
