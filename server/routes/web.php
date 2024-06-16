<?php

/*
 *  Copyright (C) 2024 Command_maker
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use App\Http\CardScanController;
use App\Http\HomeController;
use App\Http\SanctionController;
use App\Http\SubscriptionTypeController;
use App\Http\TimePeriodController;
use App\Http\UserController;
use Slim\App;

return function (App $app): void {
    $app->get('/', [HomeController::class, 'index']);

    $app->get('/api/time-periods/all', [TimePeriodController::class, 'getAll']);
    $app->post('/api/time-periods/new', [TimePeriodController::class, 'create']);
    $app->delete('/api/time-periods/delete/{id}', [TimePeriodController::class, 'delete']);
    $app->post('/api/time-periods/edit/{id}', [TimePeriodController::class, 'edit']);

    $app->post('/api/scans/get', [CardScanController::class, 'getHistoryForTimePeriod']);
    $app->post('/api/scans/new', [CardScanController::class, 'create']);

    $app->get('/api/subscription-types/all', [SubscriptionTypeController::class, 'all']);
    $app->post('/api/subscription-types/new', [SubscriptionTypeController::class, 'create']);
    $app->post('/api/subscription-types/edit/{id}', [SubscriptionTypeController::class, 'edit']);

    $app->get('/api/users/all', [UserController::class, 'all']);
    $app->post('/api/users/edit/{id}', [UserController::class, 'edit']);

    $app->get('/api/sanctions/all/{id}', [SanctionController::class, 'all']);
    $app->post('/api/sanctions/new', [SanctionController::class, 'new']);

    /* Debug route */
    $app->get('/api/debug', fn () => phpinfo());
};
