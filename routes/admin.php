<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorLogController;
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
    // Blog
    Route::get('/navigations/list', [NavigationController::class, 'getData'])->name('navigations.getData');
    Route::get('/navigations/download/pdf', [NavigationController::class, 'downloadPdf'])->name('navigations.download.pdf');
    Route::get('/navigations/trash', [NavigationController::class, 'trash'])->name('navigations.trash');
    Route::post('/navigations/{id}/restore', [NavigationController::class, 'restore'])->name('navigations.restore');
    Route::delete('/navigations/{id}/force-delete', [NavigationController::class, 'forceDelete'])->name('navigations.forceDelete');
    // Role
    Route::get('/roles/list', [RoleController::class, 'getData'])->name('roles.getData');
    Route::get('/roles/download/pdf', [RoleController::class, 'downloadPdf'])->name('roles.download.pdf');
    // Visitor Log
    Route::get('/visitorlogs/index', [VisitorLogController::class, 'index'])->name('visitorlogs.index');
    Route::get('/visitorlogs/list', [VisitorLogController::class, 'getData'])->name('visitorlogs.getData');
    Route::get('/visitorlogs/download/pdf', [VisitorLogController::class, 'downloadPdf'])->name('visitorlogs.download.pdf');
    Route::get('/visitorlogs/{id}', [VisitorLogController::class, 'show'])->name('visitorlogs.show');
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
        'navigations' => NavigationController::class,
        'roles' => RoleController::class,
        'users' => UserController::class,
        'wings' => WingController::class,
    ]);
    Route::get('/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
    Route::post('/{user}/assign-roles', [UserController::class, 'storeAssignedRoles'])->name('users.assign.roles');
})->middleware('role:Super Admin,Editor');
// });


