<?php

use App\Http\Controllers\DesenvolvedorController;
use App\Http\Controllers\NivelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'API is running']);
});
Route::apiResource('desenvolvedores', DesenvolvedorController::class);
Route::apiResource('niveis', NivelController::class);
