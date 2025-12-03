<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Livewire\BookingPage;
use App\Livewire\PeoplePage;

// Veřejné stránky
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/partneri', 'partners')->name('partners');
Route::get('/projekty', [HomeController::class, 'projects'])->name('projects.index');
Route::get('/projekty/{slug}', [HomeController::class, 'projectShow'])->name('projects.show');
// Route::get('/osobnosti', [HomeController::class, 'people'])->name('people.index');
Route::get('/osobnosti/{id}', [HomeController::class, 'personShow'])->name('people.show'); // Zde použijeme ID
Route::get('/osobnosti', PeoplePage::class)->name('people.index');
Route::get('/foto/{slug}', \App\Livewire\PhotoDetail::class)->name('photo.show');
Route::get('/o-mne', [HomeController::class, 'about'])->name('about');
Route::get('/kontakt', [HomeController::class, 'contact'])->name('contact');
Route::get('/objednavka', BookingPage::class)->name('booking');
Route::post('/projekty/{slug}/unlock', [HomeController::class, 'unlockProject'])->name('projects.unlock');

// (Volitelně) Odeslání kontaktního formuláře - zatím jen placeholder
// Route::post('/kontakt', [ContactController::class, 'send'])->name('contact.send');