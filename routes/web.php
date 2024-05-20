<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('events', EventController::class)->only(['index', 'show']);
Route::resource('albums', AlbumController::class)->only(['index', 'show']);

// Route::get('/reservation', function () {
//     return view('reservation');
// })->name('reservation.index');

Route::get('/menu', function () {
    return view('menu');
})->name('menu.index');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
