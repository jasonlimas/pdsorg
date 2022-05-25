<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreateQuoteController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\TermsConditionsController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

// Quote download for unauthenticated users (Clicking download in email)
Route::get('/quote/download/{quote}', [QuoteController::class, 'download'])->name('quote.download');

// Middleware group, for authenticated users only (any role)
Route::group([
    'middleware' => 'auth'
], function () {
    // Home
    Route::get('/', function () {
        return view('home');
    })->name('home');

    // Create Quotation
    Route::get('/quotes/create', [CreateQuoteController::class, 'index'])->name('quotes.create');
    Route::get('/quotes/create/done', [CreateQuoteController::class, 'finalize'])->name('quotes.create.finalize');
    Route::get('/quotes/create/done/{quote}', [CreateQuoteController::class, 'download'])->name('quotes.create.download');
    Route::get('/quotes/create/done/{quote}/email', [QuoteController::class, 'sendEmail'])->name('quotes.create.email');
    Route::post('/quotes/create', [CreateQuoteController::class, 'store']);
    Route::post('/upload', [UploadController::class, 'store']);

    // Quotation List
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes');
    Route::get('/quotes/{quote}', [QuoteController::class, 'view'])->name('quotes.view');
    Route::get('/quotes/{quote}/edit', [QuoteController::class, 'show'])->name('quotes.show');
    Route::get('/quotes/{quote}/copy', [QuoteController::class, 'duplicate'])->name('quotes.duplicate');
    Route::get('/quotes/{quote}/email', [QuoteController::class, 'prepareEmail'])->name('quotes.prepare-email');
    Route::get('/quotes/{quote}/email/send', [QuoteController::class, 'sendEmail'])->name('quotes.email');
    Route::post('/quotes/filter', [QuoteController::class, 'query'])->name('quotes.filter');
    Route::post('/quotes/{quote}/download', [QuoteController::class, 'download'])->name('quotes.download');
    Route::post('/quotes/{quote}', [QuoteController::class, 'update']);
    Route::post('/quotes/{quote}/copy', [QuoteController::class, 'storeDuplicate']);
    Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');

    // Profiles
    Route::get('/profiles', [ProfilesController::class, 'index'])->name('profiles');

    // User Profile
    Route::get('/profile/change-password', [ProfilesController::class, 'indexPassword'])->name('profiles.change-password');
    Route::post('/profile/change-password', [UserManagementController::class, 'updatePassword']);
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
    Route::post('/profiles/terms/{term}', [TermsConditionsController::class, 'update']);
    Route::delete('/profiles/terms/{term}', [TermsConditionsController::class, 'destroy'])->name('profiles.terms.destroy');

    // Logout
    Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
});

// Middleware group, for admin only
Route::group([
    'middleware' => 'adminrole',
], function () {
    // Admin Panel
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    // Quote
    Route::get('/admin/quote/create', [CreateQuoteController::class, 'indexManual'])->name('admin.quote.create');
    Route::post('/admin/quote/create', [CreateQuoteController::class, 'storeManual']);

    // User Management
    Route::get('/admin/user/create', [RegisterController::class, 'index'])->name('admin.user.create');
    Route::get('/admin/user/{user}', [UserManagementController::class, 'show'])->name('admin.user.show');
    Route::post('/admin/user/create', [RegisterController::class, 'store']);
    Route::post('/admin/user/{user}', [UserManagementController::class, 'update']);
    Route::delete('/admin/user/{user}', [UserManagementController::class, 'destroy'])->name('admin.user.destroy');

    // Sender Organization Profiles
    Route::get('/admin/sender/create', [SenderController::class, 'index'])->name('admin.sender.create');
    Route::get('/admin/sender/{sender}', [SenderController::class, 'show'])->name('admin.sender.show');
    Route::post('/admin/sender/create', [SenderController::class, 'store']);
    Route::post('/admin/sender/{sender}', [SenderController::class, 'update']);
    Route::post('/admin/sender/create/upload', [UploadController::class, 'senderLogoStore']);
    Route::delete('/admin/sender/{sender}', [SenderController::class, 'destroy'])->name('admin.sender.destroy');

    // Division
    Route::get('/admin/division/create', [DivisionController::class, 'index'])->name('admin.division.create');
    Route::get('/admin/division/{division}', [DivisionController::class, 'show'])->name('admin.division.show');
    Route::post('/admin/division/create', [DivisionController::class, 'store']);
    Route::post('/admin/division/{division}', [DivisionController::class, 'update']);
    Route::delete('/admin/division/{division}', [DivisionController::class, 'destroy'])->name('admin.division.destroy');
});

// Middleware group, for leader only
Route::group([
    'middleware' => 'leaderrole',
], function () {
    // Leader Panel
    Route::get('/leader', [LeaderController::class, 'index'])->name('leader');

    // User Management
    Route::get('/leader/user/create', [RegisterController::class, 'index'])->name('leader.user.create');
    Route::get('/leader/user/{user}', [UserManagementController::class, 'show'])->name('leader.user.show');
    Route::post('/leader/user/create', [RegisterController::class, 'store']);
    Route::post('/leader/user/{user}', [UserManagementController::class, 'update']);
    Route::delete('/leader/user/{user}', [UserManagementController::class, 'destroy'])->name('leader.user.destroy');
});
