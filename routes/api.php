<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/reserv/{id}', [ReservController::class, 'show']);
Route::post('/reserv', [ReservController::class, 'reserv']);

Route::post('/telegram/webhook', [HomeController::class, 'telegramWebhook']);
