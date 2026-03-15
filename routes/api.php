<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// Rooms API
Route::apiResource('rooms', RoomController::class);
