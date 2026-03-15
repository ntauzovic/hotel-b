<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

// Rooms API
Route::apiResource('rooms', RoomController::class);

// Guests API
Route::apiResource('guests', GuestController::class);
//registrovanje da su nam vidljivi sve route koje su definisane u controlleru GuestController