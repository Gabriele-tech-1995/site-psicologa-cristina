<?php

use App\Http\Controllers\Admin\ContactRequestController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/chi-sono', [PublicController::class, 'about'])->name('about');

Route::get('/aree', [PublicController::class, 'areas'])->name('areas');

Route::get('/aree/{slug}', [PublicController::class, 'areaShow'])->name('areas.show');

Route::get('/contatti', [PublicController::class, 'contact'])->name('contacts');

Route::post('/contatti', [PublicController::class, 'submit'])->name('contacts.submit');

Route::get('/testimonianze', [PublicController::class, 'testimonials'])->name('testimonials');
Route::post('/testimonianze', [PublicController::class, 'storeTestimonial'])->name('testimonials.store');

// rotte protette admin
Route::middleware('basic.auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/contatti', [ContactRequestController::class, 'index'])->name('contacts.index');
    Route::get('/contatti/{contactRequest}', [ContactRequestController::class, 'show'])->name('contacts.show');

    Route::patch('/contatti/{contactRequest}/read', [ContactRequestController::class, 'markAsRead'])
        ->name('contacts.read');

    Route::delete('/contatti/{contactRequest}', [ContactRequestController::class, 'destroy'])
        ->name('contacts.destroy');

    Route::get('/testimonianze', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('/testimonianze/{testimonial}', [TestimonialController::class, 'show'])->name('testimonials.show');

    Route::patch('/testimonianze/{testimonial}/approve', [TestimonialController::class, 'approve'])
        ->name('testimonials.approve');

    Route::patch('/testimonianze/{testimonial}/unapprove', [TestimonialController::class, 'unapprove'])
        ->name('testimonials.unapprove');

    Route::delete('/testimonianze/{testimonial}', [TestimonialController::class, 'destroy'])
        ->name('testimonials.destroy');
});
