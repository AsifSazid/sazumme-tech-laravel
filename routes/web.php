<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CounterController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GetAppointmentController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TermsAndConditionsController;
use App\Http\Controllers\PolicyController;
// use App\Http\Controllers\ReasonsToChooseUsController;
use App\Http\Controllers\RequestAQuoteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WingController;
use App\Http\Middleware\EnsurePhoneIsVerified;

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Route::get('/', function () {
//     return view('under-maintenance');
// })->name('under-maintenance');

Route::get('/about-us', function () {
    return view('frontend.about-us');
})->name('about-us');

Route::get('/our-team', function () {
    return view('frontend.our-team');
})->name('our-team');

Route::get('/our-wings', function () {
    return view('frontend.our-wings');
})->name('our-wings');

Route::get('/choose-us', function () {
    return view('frontend.choose-us');
})->name('choose-us');

Route::get('/contact-us', function () {
    return view('frontend.contact-us');
})->name('contact-us');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', EnsurePhoneIsVerified::class])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
// Route::get('/sliders/create', [SliderController::class, 'create'])->name('sliders.create');
// Route::post('/sliders', [SliderController::class, 'store'])->name('sliders.store');
// Route::get('/sliders/{slider}', [SliderController::class, 'show'])->name('sliders.show');
// Route::get('/sliders/{slider}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
// Route::post('/sliders/{slider}/update', [SliderController::class, 'update'])->name('sliders.update');
// Route::delete('/sliders/{slider}', [SliderController::class, 'delete'])->name('sliders.delete');


// admin panel er jonno middlewere diye
// Route::middleware(['auth'])->group(function () {
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    // Announcement
    Route::get('/announcements/list', [AnnouncementController::class, 'getData'])->name('announcements.getData');
    Route::get('/announcements/download/pdf', [AnnouncementController::class, 'downloadPdf'])->name('announcements.download.pdf');
    Route::get('/announcements/trash', [AnnouncementController::class, 'trash'])->name('announcements.trash');
    Route::post('/announcements/{id}/restore', [AnnouncementController::class, 'restore'])->name('announcements.restore');
    Route::delete('/announcements/{id}/force-delete', [AnnouncementController::class, 'forceDelete'])->name('announcements.forceDelete');
    Route::resources([
        'announcements' => AnnouncementController::class,
        'roles' => RoleController::class,
        'users' => UserController::class,
    ]);
    Route::get('/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
    Route::post('/{user}/assign-roles', [UserController::class, 'storeAssignedRoles'])->name('users.assign.roles');
});

Route::resources([
    // admin panel er jonno
    'blogs' => BlogController::class,
    'contact-info' => ContactInfoController::class,
    'counters' => CounterController::class,
    'get-appointments' => GetAppointmentController::class,
    // 'reason-to-choose-us' => ReasonsToChooseUsController::class,
    'policies' => PolicyController::class,
    'request-a-quote' => RequestAQuoteController::class,
    'subscribers' => SubscribeController::class,
    'teams' => TeamController::class,
    'terms-and-conditions' => TermsAndConditionsController::class,
    'testimonials' => TestimonialController::class,
    'wings' => WingController::class,
]);





require __DIR__ . '/auth.php';
