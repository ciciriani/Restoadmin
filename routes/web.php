<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return redirect()->route('login.index');
});

Route::middleware('auth')->controller(DashboardController::class)->group(function () {
    Route::get('dashboard', 'index')->name('dashboard.index');
});

Route::middleware('auth')->controller(CategoryController::class)->group(function () {
    Route::get('category', 'index')->name('category');
    Route::get('fetchCategory', 'fetchCategory')->name('category.fetch');
    Route::post('category', 'store')->name('category.store');
    Route::get('category/edit', 'edit')->name('category.edit');
    Route::post('category/edit', 'update')->name('category.update');
    Route::post('category/destroy', 'destroy')->name('category.destroy');
    Route::post('category/destroy/selected', 'destroySelected')->name('category.destroySelected');
    Route::get('category/trash', 'trash')->name('category.trash');
    Route::get('category/fetchTrash', 'fetchTrash')->name('category.fetchTrash');
    Route::post('category/restore', 'restore')->name('category.restore');
    Route::post('category/destroy/selectedTrash', 'destroySelectedTrash')->name('category.destroySelectedTrash');
});

Route::middleware('auth')->controller(UserController::class)->group(function () {
    Route::get('user', 'index')->name('user');
    Route::get('fetchUser', 'fetchUser')->name('user.fetch');
    Route::post('user', 'store')->name('user.store');
    Route::get('user/edit', 'edit')->name('user.edit');
    Route::post('user/edit', 'update')->name('user.update');
    Route::post('user/destroy', 'destroy')->name('user.destroy');
    Route::post('user/destroy/selected', 'destroySelected')->name('user.destroySelected');
});


//Auth Login
Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'index')->name('login.index');
    Route::post('login', 'store')->name('login.store');
    Route::post('logout', 'logout')->name('logout');
});

//route error
Route::get('403', function () {
    return view('errors.403');
})->name('error.403');
