<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(UsuarioController::class)->group(function() {
    Route::get('/users', 'index');
    Route::get('/users/{user}', 'show');
    Route::post('/users', 'store');
    Route::put('/users/{user}', 'update');
    Route::delete('/users/{user}', 'destroy');
});