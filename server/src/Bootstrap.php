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

namespace App;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use DI\ContainerBuilder;
use PDO;
use Slim\App;

class Bootstrap
{
    private static App $app;

    public static function bootApp(): void
    {
        self::$app = Bridge::create(self::getContainer());
        self::registerRoutes();
        self::$app->run();
    }

    private static function getContainer(): Container
    {
        $container = new ContainerBuilder();
        $container->addDefinitions([
            PDO::class => function () {
                $pdo = new PDO('sqlite:' . __DIR__ . '/../database.db');
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $pdo;
            },
        ]);

        return $container->build();
    }

    public static function registerRoutes(): void
    {
        (require __DIR__ . '/../routes/web.php')(self::$app);
    }

    public static function getApp(): App
    {
        return self::$app;
    }

    /**
     * @param  string|class-string  $service
     */
    public static function getContainerService(string $service): mixed
    {
        return self::$app->getContainer()?->get($service);
    }
}
