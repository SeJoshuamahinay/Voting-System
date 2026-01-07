<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VotingCampaignController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\ActivityLogController;
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
    Route::get('/vote/receipt', [VoteController::class, 'downloadReceipt'])->name('vote.receipt');

    // User management routes
    Route::resource('users', UserController::class);

    // Group management routes
    Route::resource('groups', GroupController::class);
    Route::post('groups/{group}/add-member', [GroupController::class, 'addMember'])->name('groups.addMember');
    Route::delete('groups/{group}/remove-member/{user}', [GroupController::class, 'removeMember'])->name('groups.removeMember');

    // User-Group management routes
    Route::get('user-groups', [UserGroupController::class, 'index'])->name('user-groups.index');
    Route::get('user-groups/api-docs', function() {
        return view('user-groups.api-docs');
    })->name('user-groups.api-docs');
    Route::get('user-groups/{user}/edit', [UserGroupController::class, 'edit'])->name('user-groups.edit');
    Route::put('user-groups/{user}', [UserGroupController::class, 'update'])->name('user-groups.update');
    Route::post('user-groups/{user}/attach', [UserGroupController::class, 'attach'])->name('user-groups.attach');
    Route::delete('user-groups/{user}/detach/{group}', [UserGroupController::class, 'detach'])->name('user-groups.detach');
    
    // API endpoints for user-group data (JSON responses)
    Route::prefix('api')->group(function() {
        Route::get('users/{user}/groups', [UserGroupController::class, 'getUserGroups'])->name('api.user-groups');
        Route::get('groups/{group}/users', [UserGroupController::class, 'getGroupUsers'])->name('api.group-users');
    });

    // Role management routes
    Route::resource('roles', RoleController::class);

    // Permission management routes
    Route::resource('permissions', PermissionController::class);

    // Activity Logs routes
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('activity-logs/stats', [ActivityLogController::class, 'stats'])->name('activity-logs.stats');
    Route::get('activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-logs.export');
    Route::get('activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::post('activity-logs/clear', [ActivityLogController::class, 'clear'])->name('activity-logs.clear');

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