<?php

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$container = new ContainerBuilder();
$container->addDefinitions([
    PDO::class => function () {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../database.db');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    },
]);

$app = Bridge::create($container->build());

(require __DIR__ . '/../routes/web.php')($app);

$app->run();
