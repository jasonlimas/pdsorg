<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreateQuoteController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\TermsConditionsController;
use Illuminate\Support\Facades\Route;

// Middleware group, for admin only
Route::group([
    'prefix' => 'admin',
    'middleware' => 'accessrole',
    'as' => 'admin'
], function () {
    // Admin Panel
    Route::get('/', [AdminController::class, 'index'])->name('');

    // User Management
    Route::get('/user/create', [RegisterController::class, 'index'])->name('.user.create');
    Route::get('/user/{user}', [UserManagementController::class, 'show'])->name('.user.show');
    Route::post('/user/create', [RegisterController::class, 'store'])->name('.user.create');
    Route::post('/user/{user}', [UserManagementController::class, 'update'])->name('.user.show');
    Route::delete('/user/{user}', [UserManagementController::class, 'destroy'])->name('.user.destroy');

    // Sender Organization Profiles
    Route::get('/sender/create', [SenderController::class, 'index'])->name('.sender.create');
    Route::get('/sender/{sender}', [SenderController::class, 'show'])->name('.sender.show');
    Route::post('/sender/create', [SenderController::class, 'store'])->name('.sender.create');
    Route::post('/sender/{sender}', [SenderController::class, 'update'])->name('.sender.show');
    Route::delete('/sender/{sender}', [SenderController::class, 'destroy'])->name('.sender.destroy');

    // Division
    Route::get('/division/create', [DivisionController::class, 'index'])->name('.division.create');
    Route::get('/division/{division}', [DivisionController::class, 'show'])->name('.division.show');
    Route::post('/division/create', [DivisionController::class, 'store'])->name('.division.create');
    Route::post('/division/{division}', [DivisionController::class, 'update'])->name('.division.show');
    Route::delete('/division/{division}', [DivisionController::class, 'destroy'])->name('.division.destroy');
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
Route::get('/quotes/create/done', [CreateQuoteController::class, 'finalize'])->name('quotes.create.finalize');
Route::get('/quotes/create/done/{quote}', [CreateQuoteController::class, 'download'])->name('quotes.create.download');
Route::post('/quotes/create', [CreateQuoteController::class, 'store']);

// Profiles
Route::get('/profiles', [ProfilesController::class, 'index'])->name('profiles')->middleware('auth');

// User Profile
Route::post('/profiles', [ProfilesController::class, 'update'])->name('profiles.update');

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
