<?php

use App\Http\Controllers\Admin\ContactRequestController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/chi-sono', [PublicController::class, 'about'])->name('about');

Route::get('/aree', [PublicController::class, 'areas'])->name('areas');

Route::get('/aree/{slug}', [PublicController::class, 'areaShow'])->name('areas.show');

Route::get('/primo-colloquio', [PublicController::class, 'firstInterview'])->name('first-interview');

Route::get('/contatti', [PublicController::class, 'contact'])->name('contacts');

Route::post('/contatti', [PublicController::class, 'submit'])
    ->middleware('throttle:contact-form-submit')
    ->name('contacts.submit');

Route::get('/testimonianze', [PublicController::class, 'testimonials'])->name('testimonials');
Route::post('/testimonianze', [PublicController::class, 'storeTestimonial'])->name('testimonials.store');
Route::view('/privacy-policy', 'privacy')->name('privacy');
Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => route('home'), 'priority' => '1.0'],
        ['loc' => route('about'), 'priority' => '0.9'],
        ['loc' => route('areas'), 'priority' => '0.9'],
        ['loc' => route('first-interview'), 'priority' => '0.8'],
        ['loc' => route('contacts'), 'priority' => '0.9'],
        ['loc' => route('testimonials'), 'priority' => '0.8'],
        ['loc' => route('privacy'), 'priority' => '0.5'],
    ];

    $areaSlugs = [
        'ansia-e-gestione-dello-stress',
        'umore-basso',
        'difficolta-relazionali',
        'autostima',
        'difficolta-scolastiche',
        'disturbi-del-neurosviluppo',
        'genitorialita',
        'valutazioni-psicodiagnostiche',
        'potenziamento-funzioni-esecutive',
        'potenziamento-abilita-scolastiche',
        'intervento-di-gruppo-area-emotiva-relazionale',
        'tutor-dsa-bes-adhd',
    ];

    foreach ($areaSlugs as $slug) {
        $urls[] = ['loc' => route('areas.show', ['slug' => $slug]), 'priority' => '0.8'];
    }

    return response()
        ->view('sitemap', ['urls' => $urls])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    $content = implode("\n", [
        'User-agent: *',
        'Allow: /',
        'Disallow: /admin',
        'Sitemap: '.route('sitemap'),
    ]);

    return response($content, 200)->header('Content-Type', 'text/plain');
});

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
