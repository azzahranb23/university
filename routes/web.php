<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProjectContentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Models\Major;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

// Protected routes
Route::middleware(['auth'])->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

    // Lihat semua proyek
    Route::get('/projects', [ProjectController::class, 'publicIndex'])->name('projects.public');
    // Daftar proyek yang bisa di-apply
    Route::post('/projects/{project}/apply', [ApplicationController::class, 'store'])->name('projects.apply');
    // Lihat Pemilik Proyek
    Route::get('/projects/{user_id}/owner', [ProjectController::class, 'owner'])->name('projects.owner');

    // Lihay Proyek Saya (Fillter Semua) - Proyek yang pernah di-apply
    Route::get('/Application/all', [ApplicationController::class, 'all'])->name('application.all');
    // Lihay Proyek Saya (Fillter request) - Proyek sudah di-apply tapi belum diterima atau ditolak
    Route::get('/Application/request', [ApplicationController::class, 'request'])->name('application.request');
    // Lihay Proyek Saya (Fillter on going) - Proyek yang sudah diterima tapi belum selesai
    Route::get('/Application/on-going', [ApplicationController::class, 'onGoing'])->name('application.on-going');
    // Lihay Proyek Saya (Fillter selesai) - Proyek yang sudah selesai
    Route::get('/Application/finished', [ApplicationController::class, 'finished'])->name('application.finished');
    // Lihay Proyek Saya (Fillter ditolak) - Proyek yang sudah ditolak
    Route::get('/Application/rejected', [ApplicationController::class, 'rejected'])->name('application.rejected');
    // Proyek Selesai
    Route::post('/applications/{application}/finish', [ApplicationController::class, 'finish'])->name('applications.finish');
    // Lihat Detail Proyek yang Saya daftar
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    // Terima Proyek
    Route::post('/applications/{id}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
    // Tolak Proyek
    Route::post('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
    // Update Periode Proyek
    Route::patch('/applications/{application}/update-period', [ApplicationController::class, 'updatePeriod'])->name('applications.update-period');

    // Lihat Daftar Proyek yang Saya Buat / Inisiasi
    Route::get('/projects/my-projects', [ProjectController::class, 'myProjects'])->name('projects.my');
    // Buat Proyek Baru / Inisiasi
    Route::get('/projects/initiate', [ProjectController::class, 'create'])->name('projects.initiate');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    // Edit Project
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    // Delete Project
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    // Complete Project
    Route::patch('/applications/{application}/complete', [ProjectController::class, 'complete'])->name('projects.complete');
    // Activate Project
    Route::patch('/projects/{project}/activate', [ProjectController::class, 'activate'])->name('projects.activate');


    // Dalam group middleware auth
    Route::prefix('project-contents')->group(function () {
        Route::post('/{content}/upload-document', [ProjectContentController::class, 'uploadDocument'])->name('project-contents.upload-document');
        Route::delete('/{content}/delete-document', [ProjectContentController::class, 'deleteDocument'])->name('project-contents.delete-document');
    });

    // Project Contents Routes
    Route::middleware(['auth'])->group(function () {
        Route::prefix('project-contents')->group(function () {
            Route::post('/', [ProjectContentController::class, 'store'])->name('project-contents.store');
            Route::get('/{content_id}', [ProjectContentController::class, 'show'])->name('project-contents.show');
            Route::put('/{content_id}', [ProjectContentController::class, 'update'])->name('project-contents.update');
            Route::delete('/{content_id}', [ProjectContentController::class, 'destroy'])->name('project-contents.destroy');

            Route::post('/{content}/update-link', [ProjectContentController::class, 'updateLink']);
        });
    });

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User management routes
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
        Route::get('/users/create/{role}', [AdminDashboardController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminDashboardController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}', [AdminDashboardController::class, 'showUser'])->name('users.show');
        Route::get('/users/{id}/edit', [AdminDashboardController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminDashboardController::class, 'destroyUser'])->name('users.destroy');

        Route::get('/departments/{department}/majors', function ($department) {
            return Major::where('department_id', $department)->get();
        });

        // Category management routes
        Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('categories');
        Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{id}', [AdminDashboardController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{id}', [AdminDashboardController::class, 'destroyCategory'])->name('categories.destroy');

        // Department management routes
        Route::get('/departments', [AdminDashboardController::class, 'departments'])->name('departments');
        Route::post('/departments', [AdminDashboardController::class, 'storeDepartment'])->name('departments.store');
        Route::put('/departments/{id}', [AdminDashboardController::class, 'updateDepartment'])->name('departments.update');
        Route::delete('/departments/{id}', [AdminDashboardController::class, 'destroyDepartment'])->name('departments.destroy');

        // Major management routes
        Route::get('/majors', [AdminDashboardController::class, 'majors'])->name('majors');
        Route::post('/majors', [AdminDashboardController::class, 'storeMajor'])->name('majors.store');
        Route::put('/majors/{id}', [AdminDashboardController::class, 'updateMajor'])->name('majors.update');
        Route::delete('/majors/{id}', [AdminDashboardController::class, 'destroyMajor'])->name('majors.destroy');

        // Project management routes
        Route::get('/projects', [AdminDashboardController::class, 'projects'])->name('projects');
        Route::post('/projects', [AdminDashboardController::class, 'storeProject'])->name('projects.store');
        Route::put('/projects/{id}', [AdminDashboardController::class, 'updateProject'])->name('projects.update');
        Route::delete('/projects/{id}', [AdminDashboardController::class, 'destroyProject'])->name('projects.destroy');

        // Applications management routes
        Route::get('/applications', [AdminDashboardController::class, 'applications'])->name('applications');
        Route::put('/applications/{id}/status', [AdminDashboardController::class, 'updateApplicationStatus'])->name('applications.status');

        // Project Contents management routes
        Route::get('/project-contents', [AdminDashboardController::class, 'projectContents'])->name('project-contents');
    });
});
