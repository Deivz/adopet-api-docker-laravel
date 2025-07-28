<?php

use App\Http\Controllers\ResponsibleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function() {
    Route::get('/usuarios', 'index');
    Route::get('/usuarios/{uuid}', 'show');
    Route::post('/usuarios', 'store');
    Route::put('/usuarios/{user}', 'update');
    Route::delete('/usuarios/{user}', 'destroy');
});

Route::controller(ResponsibleController::class)->group(function() {
    Route::get('/responsaveis', 'index');
    Route::get('/responsaveis/{uuid}', 'show');
    Route::post('/responsaveis', 'store');
    Route::put('/responsaveis/{responsible}', 'update');
    Route::delete('/responsaveis/{responsible}', 'destroy');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});