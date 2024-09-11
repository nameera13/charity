<?php

use Illuminate\Support\Facades\Route;

// Front
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\FAQController;
use App\Http\Controllers\Front\VolunteerController;

// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SpecialController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\FAQsController;
use App\Http\Controllers\Admin\AdminVolunteerController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('front.home');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index']);
Route::get('/faqs', [FAQController::class, 'index']);
Route::get('/volunteers', [VolunteerController::class, 'index']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth','verified')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::put('/profile', [ProfileController::class, 'profile'])->name('profile.update');
    Route::put('/change-password', [ProfileController::class, 'changePassword']);
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';






/*----- Admin -----*/

Route::middleware('admin')->prefix('admin')->group(function(){
    Route::get('/dashboard',[AdminController::class,'dashboard']);
    Route::get('/profile',[AdminController::class,'profile']);
    Route::post('/update-profile',[AdminController::class,'update_profile']);

    /*-- Slider --*/
    Route::resource('slider',SliderController::class);
    Route::get('slider-datatable', [SliderController::class, 'getDataTable']);

    /*-- Special --*/
    Route::get('/special',[SpecialController::class,'edit']);
    Route::put('/special/{id}',[SpecialController::class,'update']);

    /*-- Feature --*/
    Route::resource('feature',FeatureController::class);
    Route::get('feature-datatable', [FeatureController::class, 'getDataTable']);
    Route::post('feature-section-item', [FeatureController::class, 'featureSectionItem']);

    /*-- Testimonials --*/
    Route::resource('testimonial',TestimonialController::class);
    Route::get('testimonial-datatable', [TestimonialController::class, 'getDataTable']);
    Route::post('testimonial-section-item', [TestimonialController::class, 'testimonialSectionItem']);

    /*-- Counter --*/
    Route::get('counter',[CounterController::class,'edit']);
    Route::put('counter/{id}',[CounterController::class,'update']);
    
    /*-- FAQ --*/
    Route::resource('faqs',FAQsController::class);
    Route::get('faqs-datatable', [FAQsController::class, 'getDataTable']);
    
    /*-- Volunteer --*/
    Route::resource('volunteer',AdminVolunteerController::class);
    Route::get('volunteer-datatable', [AdminVolunteerController::class, 'getDataTable']);
    
});

Route::prefix('admin')->group(function(){
    Route::get('/login',[AdminController::class,'login']);
    Route::post('/login-submit',[AdminController::class,'login_submit']);
    Route::get('/logout',[AdminController::class,'logout']);
    Route::get('/forget-password',[AdminController::class,'forget_password']);
    Route::post('/forget-password-submit',[AdminController::class,'forget_password_submit']);
    Route::get('/reset-password/{token}/{email}',[AdminController::class,'reset_password']);
    Route::post('/reset-password-submit',[AdminController::class,'reset_password_submit']);
});
