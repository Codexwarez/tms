<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectFileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TimeLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('/staff', StaffController::class);

        // Admin project CRUD
        Route::resource('/projects', ProjectController::class)->except(['show']);
    });

    // Staff project list + status update
    Route::get('/staff/projects', [ProjectController::class, 'staffIndex'])->name('projects.index');
    Route::put('/projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('projects.status');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/projects/{project}/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/projects/{project}/reports', [ReportController::class, 'store'])->name('reports.store');

    // Staff Requests
    Route::get('/requests', [StaffRequestController::class, 'index'])->name('requests.index');
    Route::get('/projects/{project}/requests/create', [StaffRequestController::class, 'create'])->name('requests.create');
    Route::post('/projects/{project}/requests', [StaffRequestController::class, 'store'])->name('requests.store');
    Route::put('/requests/{staffRequest}/status', [StaffRequestController::class, 'updateStatus'])->name('requests.updateStatus');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Shared resources (both admin & staff can access)
    Route::resource('projects', ProjectController::class)->only(['show']); // shared show route
    Route::resource('project-files', ProjectFileController::class)->only(['store', 'destroy']);
    Route::resource('comments', CommentController::class)->only(['store', 'destroy']);
    Route::resource('time-logs', TimeLogController::class)->only(['store', 'destroy']);
    // routes/web.php

    Route::get('project-files/{projectFile}/download', [ProjectFileController::class, 'download'])
        ->name('project-files.download');
        
    Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
        return (int) $user->id === (int) $id;
    });
    Route::put('/projects/{project}/progress', [ProjectController::class, 'updateProgress'])
        ->name('projects.progress.update');
});

require __DIR__ . '/auth.php';