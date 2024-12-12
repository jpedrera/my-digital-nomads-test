<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Event\EventController;
use App\Http\Controllers\Api\Event\EventReservationController;
use App\Http\Controllers\Api\Event\EventReviewController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'events', 'as' => 'events.'], function () {
    Route::get('', [EventController::class, 'index'])->name('index');
    Route::post('', [EventController::class, 'store'])->name('store');

    Route::post('{event}/reservations', [EventReservationController::class, 'store'])->name('reservation.store');

    Route::get('{event}/reviews', [EventReviewController::class, 'index'])->name('reviews.index');
    Route::post('{event}/reviews', [EventReviewController::class, 'store'])->name('reviews.store');
});
