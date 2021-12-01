<?php

declare(strict_types=1);

use App\Controllers\UserController;
use App\Controllers\StocksController;
use Slim\App;

return function (App $app) {
    //creat user
    $app->post('/create-user', UserController::class . ':insertUsers');

    //request a stock quote and send email
    $app->get('/request-stock', StocksController::class . ':requestStock');

    //show history
    $app->get('/history', StocksController::class . ':getHistory');

};