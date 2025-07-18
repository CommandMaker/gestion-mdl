<?php

use App\Http\Controllers\Security\LoginController;
use App\Http\Controllers\SubscriptionTypeController;
use App\Http\Middleware\IsUserAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::name('api.')->prefix('/api')->group(function () {
    Route::get('/', function () {
        return [];
    });

    Route::post('/login', [LoginController::class, 'login']);

    Route::prefix('/subscription-type')->name('st.')->controller(SubscriptionTypeController::class)->group(function () {
        Route::get('/collection', 'get')->middleware(IsUserAdminMiddleware::class)->name('get-collection');

        Route::post('/create', 'create')->name('create');

        Route::post('/delete/{id}', 'delete')->whereNumber('id')->name('delete');

        Route::patch('/edit/{id}', 'edit')->whereNumber('id')->name('edit');
    });
});
