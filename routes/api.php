<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Rooms API
Route::apiResource('rooms', RoomController::class);

// Guests API
Route::apiResource('guests', GuestController::class);

// Reservations API
Route::apiResource('reservations', ReservationController::class);
