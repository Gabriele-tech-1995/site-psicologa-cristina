<?php

use App\Http\Controllers\Admin\ContactRequestController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/chi-sono', [PublicController::class, 'about'])->name('about');

Route::get('/aree', [PublicController::class, 'areas'])->name('areas');

Route::get('/aree/{slug}', [PublicController::class, 'areaShow'])->name('areas.show');

Route::get('/contatti', [PublicController::class, 'contact'])->name('contacts');

Route::post('/contatti', [PublicController::class, 'submit'])->name('contacts.submit');

// rotte protette admin
Route::middleware('basic.auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/contatti', [ContactRequestController::class, 'index'])->name('contacts.index');
    Route::get('/contatti/{contactRequest}', [ContactRequestController::class, 'show'])->name('contacts.show');

    Route::patch('/contatti/{contactRequest}/read', [ContactRequestController::class, 'markAsRead'])
        ->name('contacts.read');

    Route::delete('/contatti/{contactRequest}', [ContactRequestController::class, 'destroy'])
        ->name('contacts.destroy');
});
