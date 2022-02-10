<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreateQuoteController;
use App\Http\Controllers\ProfilesController;
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

// Home
Route::get('/', function () {
    return view('home');
})->name('home');

// Quotation List

// Create Quotation
Route::get('/quote/create', [CreateQuoteController::class, 'index'])->name('quote.create');
Route::post('/quote/create', [CreateQuoteController::class, 'store']);

// Profiles
Route::get('/profiles', [ProfilesController::class, 'index'])->name('profiles');
Route::get('/profiles/client/create', [ClientController::class, 'index'])->name('profiles.client.create');
Route::post('/profiles/client/create', [ClientController::class, 'store']);
Route::delete('profiles/client/{client}', [ClientController::class, 'destroy'])->name('profiles.client.destroya');

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

// Logout
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// Add user?
