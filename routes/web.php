<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Veřejné stránky
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/projekty', [HomeController::class, 'projects'])->name('projects.index');
Route::get('/projekty/{slug}', [HomeController::class, 'projectShow'])->name('projects.show');

Route::get('/osobnosti', [HomeController::class, 'people'])->name('people.index');
Route::get('/osobnosti/{id}', [HomeController::class, 'personShow'])->name('people.show'); // Zde použijeme ID

Route::get('/o-mne', [HomeController::class, 'about'])->name('about');
Route::get('/kontakt', [HomeController::class, 'contact'])->name('contact');

// (Volitelně) Odeslání kontaktního formuláře - zatím jen placeholder
// Route::post('/kontakt', [ContactController::class, 'send'])->name('contact.send');