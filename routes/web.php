<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VotingCampaignController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;


// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/guidelines', function () {
    return view('guidelines');
})->name('guidelines');

Route::get('/results', [App\Http\Controllers\ResultsController::class, 'index'])->name('results');
Route::get('/results/{id}', [App\Http\Controllers\ResultsController::class, 'show'])->name('results.show');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Voting
    Route::get('/voting', [VoteController::class, 'index'])->name('voting.index');
    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');

    // User management routes
    Route::resource('users', UserController::class);

    // Group management routes
    Route::resource('groups', GroupController::class);
    Route::post('groups/{group}/add-member', [GroupController::class, 'addMember'])->name('groups.addMember');
    Route::delete('groups/{group}/remove-member/{user}', [GroupController::class, 'removeMember'])->name('groups.removeMember');

    // Role management routes
    Route::resource('roles', RoleController::class);

    // Permission management routes
    Route::resource('permissions', PermissionController::class);

    // Voting Campaign management routes
    Route::resource('voting-campaigns', VotingCampaignController::class);
    Route::get('voting-campaigns/{votingCampaign}/positions', [VotingCampaignController::class, 'positions'])
        ->name('voting-campaigns.positions');
    Route::post('voting-campaigns/{votingCampaign}/positions', [VotingCampaignController::class, 'storePosition'])
        ->name('voting-campaigns.positions.store');
    Route::delete('voting-campaigns/{votingCampaign}/positions/{position}', [VotingCampaignController::class, 'deletePosition'])
        ->name('voting-campaigns.positions.delete');
    Route::get('voting-campaigns/{votingCampaign}/candidates', [VotingCampaignController::class, 'candidates'])
        ->name('voting-campaigns.candidates');
    Route::post('voting-campaigns/{votingCampaign}/candidates', [VotingCampaignController::class, 'storeCandidate'])
        ->name('voting-campaigns.candidates.store');
    Route::delete('voting-campaigns/{votingCampaign}/candidates/{candidate}', [VotingCampaignController::class, 'deleteCandidate'])
        ->name('voting-campaigns.candidates.delete');
});