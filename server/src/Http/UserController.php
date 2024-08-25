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
use App\Domain\User\User;
use App\Domain\User\UserRepository;
use GuzzleHttp\Psr7\Response;
use Valitron\Validator;

class UserController
{
    use ControllerTrait;

    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function all(Response $response): Response
    {
        return $this->json($response, [
            'status' => 'ok',
            'data' => $this->repository->all(),
        ]);
    }

    public function edit(Response $response, int $id): Response
    {
        $validator = new Validator($_POST);
        $validator->rules([
            'required' => ['firstname', 'lastname', 'gender', 'code', 'grade', 'subscriptionTypeId'],
            'optional' => ['subscriptionEnd'],
        ]);

        if (!$validator->validate()) {
            return $this->json($response, [
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $_POST['id'] = $id;
        $user = User::mapFromArray($_POST);
        $this->repository->edit($user);

        return $this->json($response, [
            'status' => 'ok',
        ]);
    }

    public function delete(Response $response, int $id): Response
    {
        if (!$this->repository->findOne($id)) {
            return $this->json($response, [
                'status' => 'error',
                'message' => 'No user found'
            ], 400);
        }

        $this->repository->delete($id);

        return $this->json($response, [
            'status' => 'ok'
        ]);
    }
}
