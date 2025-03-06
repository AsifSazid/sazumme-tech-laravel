<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SliderController;
use App\Http\Controllers\HeroAreaController;
use App\Http\Controllers\WhoWeAreController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\ReasonsToChooseUsController;
use App\Http\Controllers\OurExpertiseController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GetAppointmentController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\TermsAndConditionsController;
use App\Http\Controllers\AboutCompanyController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\RequestAQuoteController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

Route::resources([
    'sliders' => SliderController::class,
    'hero-areas' => HeroAreaController::class,
    'who-we-are' => WhoWeAreController::class,
    'counters' => CounterController::class,
    'reason-to-choose-us' => ReasonsToChooseUsController::class,
    'our-expertise' => OurExpertiseController::class,
    'case-studies' => CaseStudyController::class,
    'testimonials' => TestimonialController::class,
    'teams' => TeamController::class,
    'blogs' => BlogController::class,
    'get-appointments' => GetAppointmentController::class,
    'subscribers' => SubscribeController::class,
    'footers' => FooterController::class,
    'headers' => HeaderController::class,
    'services' => ServicesController::class,
    'links' => LinksController::class,
    'contact-info' => ContactInfoController::class,
    'terms-and-conditions' => TermsAndConditionsController::class,
    'about-companies' => AboutCompanyController::class,
    'policies' => PolicyController::class,
    'request-a-quote' => RequestAQuoteController::class,
]);

require __DIR__.'/auth.php';
