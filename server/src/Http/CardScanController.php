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
use App\Domain\CardScan\CardScanRepository;
use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use Valitron\Validator;

class CardScanController
{
    use ControllerTrait;

    public function getHistoryForTimePeriod(Response $response, CardScanRepository $repository): Response
    {
        $validator = new Validator($_POST);
        $validator->rules([
            'required' => ['timePeriodId'],
            'optional' => ['date'],
        ]);

        if (!isset($_POST['date'])) {
            $_POST['date'] = (new DateTimeImmutable())->format('Y-m-d');
        }

        $history = $repository->all($_POST['date'], $_POST['timePeriodId']);

        return $this->json($response, [
            'status' => 'ok',
            'data' => $history,
        ]);
    }
}
