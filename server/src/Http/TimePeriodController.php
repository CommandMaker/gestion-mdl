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

namespace App\Http;

use App\Core\Http\ControllerTrait;
use App\Domain\TimePeriod\TimePeriod;
use GuzzleHttp\Psr7\Response;
use PDO;

class TimePeriodController
{
    use ControllerTrait;

    public function getAll(Response $response, PDO $pdo): Response
    {
        $q = $pdo->prepare('SELECT * from time_periods');
        $q->execute();
        $data = array_map(fn ($a) => TimePeriod::mapFromArray($a)->toArray(), $q->fetchAll());

        return $this->json($response, [
            'status' => 'ok',
            'data' => $data,
        ]);
    }
}
