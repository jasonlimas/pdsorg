<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreateQuoteController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\TermsConditionsController;
use Illuminate\Support\Facades\Route;

// Middleware group
Route::group([
    'prefix' => 'admin',
    'middleware' => 'accessrole',
    'as' => 'admin'
], function () {
    // Admin Panel
    Route::get('/', [AdminController::class, 'index']);
});

// Home
Route::get('/', function () {
    return view('home');
})->name('home');

// Quotation List
Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes');
Route::post('/quotes/{quote}/download', [QuoteController::class, 'download'])->name('quotes.download');
Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');

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
Route::post('/profiles/sender/{sender}', [SenderController::class, 'update']);
Route::delete('/profiles/sender/{sender}', [SenderController::class, 'destroy'])->name('profiles.sender.destroy');

// Client Profiles
Route::get('/profiles/client/create', [ClientController::class, 'index'])->name('profiles.client.create');
Route::get('/profiles/client/{client}', [ClientController::class, 'show'])->name('profiles.client.show');
Route::post('/profiles/client/create', [ClientController::class, 'store']);
Route::post('/profiles/client/{client}', [ClientController::class, 'update']);
Route::delete('/profiles/client/{client}', [ClientController::class, 'destroy'])->name('profiles.client.destroy');

// Terms & Conditions
Route::get('/profiles/terms/create', [TermsConditionsController::class, 'index'])->name('profiles.terms.create');
Route::get('/profiles/terms/{term}', [TermsConditionsController::class, 'show'])->name('profiles.terms.show');
Route::post('/profiles/terms/create', [TermsConditionsController::class, 'store']);
Route::post('profiles/terms/{term}', [TermsConditionsController::class, 'update']);
Route::delete('/profiles/terms/{term}', [TermsConditionsController::class, 'destroy'])->name('profiles.terms.destroy');

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

// Logout
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
