<?php

use App\Http\Controllers\Security\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::name('api.')->prefix('/api')->group(function () {
    Route::get('/', function () {
        return [];
    });

    Route::post('/login', [LoginController::class, 'login']);
});
