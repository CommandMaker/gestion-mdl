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
use Valitron\Validator;

class TimePeriodController
{
    use ControllerTrait;

    public function getAll(Response $response, PDO $pdo): Response
    {
        $q = $pdo->prepare('SELECT * from time_periods');
        $q->execute();
        $data = array_map(fn ($a) => TimePeriod::mapFromArray($a)->toArray(['id'], true), $q->fetchAll());

        return $this->json($response, [
            'status' => 'ok',
            'data' => $data,
        ]);
    }

    public function create(Response $response, PDO $pdo): Response
    {
        $validator = new Validator($_POST);

        $validator->rule('required', ['displayName', 'startTime', 'endTime']);
        $validator->rule('lengthMin', 'displayName', 2);

        if (!$validator->validate()) {
            return $this->json($response, [
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $entity = TimePeriod::mapFromArray($_POST);

        $q = $pdo->prepare('INSERT INTO time_periods (displayName, startTime, endTime) VALUES (?, ?, ?)');
        $q->execute([$entity->getDisplayName(), $entity->serialize('startTime'), $entity->serialize('endTime')]);

        return $this->json($response, [
            'status' => 'ok',
            'data' => $entity->toArray(['displayName', 'startTime', 'endTime']),
        ]);
    }

    public function delete(Response $response, int $id, PDO $pdo): Response
    {
        $q = $pdo->prepare('DELETE FROM time_periods WHERE id = ?');
        $q->execute([$id]);

        return $this->json($response, [
            'status' => 'ok',
        ]);
    }

    public function edit(Response $response, int $id, PDO $pdo): Response
    {
        $validator = new Validator($_POST);

        $validator->rule('required', ['displayName', 'startTime', 'endTime']);
        $validator->rule('lengthMin', 'displayName', 2);

        if (!$validator->validate()) {
            return $this->json($response, [
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $qE = $pdo->prepare('SELECT * FROM time_periods WHERE id = ?');
        $qE->execute([$id]);

        $en = $qE->fetchAll();

        if (count($en) === 0) {
            return $this->json($response, [
                'status' => 'error',
                'message' => 'Cannot find the specified period',
            ], 400);
        }

        $entity = TimePeriod::mapFromArray($_POST);
        $entity->setId($en[0]['id']);

        $q = $pdo->prepare('UPDATE time_periods SET displayName = ?, startTime = ?, endTime = ? WHERE id = ?');
        //$q->execute([$entity->getDisplayName(), $entity->getStartTimeSerialized(), $entity->getEndTimeSerialized(), $entity->getId()]);

        return $this->json($response, [
            'status' => 'ok',
        ]);
    }
}
