<?php

use App\Http\HomeController;
use Slim\App;

return function (App $app): void {
    $app->get('/', [HomeController::class, 'index']);
};
