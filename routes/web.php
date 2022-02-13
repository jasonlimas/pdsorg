<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreateQuoteController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\SenderController;
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
Route::get('/quotes/create', [CreateQuoteController::class, 'index'])->name('quotes.create');
Route::post('/quotes/create', [CreateQuoteController::class, 'store']);

// Profiles
Route::get('/profiles', [ProfilesController::class, 'index'])->name('profiles')->middleware('auth');

// User Profile
Route::post('/profiles', [ProfilesController::class, 'update'])->name('profiles.update');

// Sender Organization Profiles
Route::get('/profiles/sender/create', [SenderController::class, 'index'])->name('profiles.sender.create');
Route::get('/profiles/sender/{sender}', [SenderController::class, 'show'])->name('profiles.sender.show');
Route::post('/profiles/sender/create', [SenderController::class, 'store']);
Route::post('/profiles/sender/{sender}', [SenderController::class, 'update'])->name('profiles.sender.update');
Route::delete('/profiles/sender/{sender}', [SenderController::class, 'destroy'])->name('profiles.sender.destroy');

// Client Profiles
Route::get('/profiles/client/create', [ClientController::class, 'index'])->name('profiles.client.create');
Route::get('/profiles/client/{client}', [ClientController::class, 'show'])->name('profiles.client.show');
Route::post('/profiles/client/create', [ClientController::class, 'store']);
Route::post('/profiles/client/{client}', [ClientController::class, 'update'])->name('profiles.client.update');
Route::delete('/profiles/client/{client}', [ClientController::class, 'destroy'])->name('profiles.client.destroy');

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

// Logout
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// Add user?
