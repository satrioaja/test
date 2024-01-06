<?php

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

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login_view'])->name('login');
Route::post('/login-post', [App\Http\Controllers\AuthController::class, 'login_post'])->name('login-post');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pelatihan', [App\Http\Controllers\PelatihanController::class, 'index'])->name('pelatihan.index');
    Route::get('/pelatihan/create', [App\Http\Controllers\PelatihanController::class, 'create'])->name('pelatihan.create');
    Route::post('/pelatihan/store', [App\Http\Controllers\PelatihanController::class, 'store'])->name('pelatihan.store');
    Route::delete('/pelatihan/destroy/{id}', [App\Http\Controllers\PelatihanController::class, 'destroy'])->name('pelatihan.destroy');

    Route::get('/data-latih', [App\Http\Controllers\DataLatihController::class, 'index'])->name('data-latih.index');

    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
