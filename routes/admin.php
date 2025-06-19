<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WingController;
use Illuminate\Support\Facades\Route;


// admin panel er jonno middlewere diye
// Route::middleware(['web', 'auth:admin'])->prefix('/admin')->name('admin.')->group(function () {
Route::middleware(['web', 'auth:admin'])->prefix('/admin')->name('admin.')->group(function () {
    // Route::middleware(['role:Super Admin'])->group(function () {
        // Announcement
        Route::get('/announcements/list', [AnnouncementController::class, 'getData'])->name('announcements.getData');
        Route::get('/announcements/download/pdf', [AnnouncementController::class, 'downloadPdf'])->name('announcements.download.pdf');
        Route::get('/announcements/trash', [AnnouncementController::class, 'trash'])->name('announcements.trash');
        Route::post('/announcements/{id}/restore', [AnnouncementController::class, 'restore'])->name('announcements.restore');
        Route::delete('/announcements/{id}/force-delete', [AnnouncementController::class, 'forceDelete'])->name('announcements.forceDelete');
        // Blog
        Route::get('/blogs/list', [BlogController::class, 'getData'])->name('blogs.getData');
        Route::get('/blogs/download/pdf', [BlogController::class, 'downloadPdf'])->name('blogs.download.pdf');
        Route::get('/blogs/trash', [BlogController::class, 'trash'])->name('blogs.trash');
        Route::post('/blogs/{id}/restore', [BlogController::class, 'restore'])->name('blogs.restore');
        Route::delete('/blogs/{id}/force-delete', [BlogController::class, 'forceDelete'])->name('blogs.forceDelete');
        // Role
        Route::get('/roles/list', [RoleController::class, 'getData'])->name('roles.getData');
        Route::get('/roles/download/pdf', [RoleController::class, 'downloadPdf'])->name('roles.download.pdf');
        // Wing
        Route::get('/wings/list', [WingController::class, 'getData'])->name('wings.getData');
        Route::get('/wings/download/pdf', [WingController::class, 'downloadPdf'])->name('wings.download.pdf');
        Route::get('/wings/trash', [WingController::class, 'trash'])->name('wings.trash');
        Route::post('/wings/{id}/restore', [WingController::class, 'restore'])->name('wings.restore');
        Route::delete('/wings/{id}/force-delete', [WingController::class, 'forceDelete'])->name('wings.forceDelete');
        //Resources
        Route::resources([
            'announcements' => AnnouncementController::class,
            'blogs' => BlogController::class,
            'roles' => RoleController::class,
            'users' => UserController::class,
            'wings' => WingController::class,
        ]);
        Route::get('/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
        Route::post('/{user}/assign-roles', [UserController::class, 'storeAssignedRoles'])->name('users.assign.roles');
    })->middleware('role:Super Admin,Editor');
// });
    