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
use App\Domain\Sanction\Sanction;
use App\Domain\Sanction\SanctionRepository;
use GuzzleHttp\Psr7\Response;
use Valitron\Validator;

class SanctionController
{
    use ControllerTrait;

    public function __construct(
        private SanctionRepository $repository
    ) {
    }

    public function all(Response $response, int $id): Response
    {
        return $this->json($response, [
            'status' => 'ok',
            'data' => $this->repository->all($id),
        ]);
    }

    public function new(Response $response): Response
    {
        $validator = new Validator($_POST);

        $validator->rules([
            'required' => ['targetId', 'adminId', 'dateIssued', 'message'],
        ]);

        $this->repository->create(Sanction::mapFromArray($_POST));

        return $this->json($response, [
            'status' => 'ok',
        ]);
    }
}
