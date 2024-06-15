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

namespace App\Domain\User;

use PDO;

class UserRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    /**
     * @return User[]
     */
    public function all(int $limit = 10): array
    {
        $q = $this->pdo->prepare('SELECT * FROM users LIMIT ?');
        $q->execute([$limit]);

        return array_map(fn ($el) => User::mapFromArray($el), $q->fetchAll());
    }

    public function create(User $user): void
    {
        $q = $this->pdo->prepare('INSERT INTO users (firstname, lastname, gender, code, grade, subscriptionTypeId, subscriptionEnd) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $q->execute([
            $user->getFirstname(),
            $user->getLastname(),
            $user->getGender(),
            $user->getCode(),
            $user->getGrade(),
            $user->getSubscriptionTypeId(),
            $user->getSubscriptionEndSerialized(),
        ]);
    }

    public function edit(User $user): void
    {
        $q = $this->pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, gender = ?, code = ?, grade = ?, subscriptionTypeId = ?, subscriptionEnd = ? WHERE id = ?');
        $q->execute([
            $user->getFirstname(),
            $user->getLastname(),
            $user->getGender(),
            $user->getCode(),
            $user->getGrade(),
            $user->getSubscriptionTypeId(),
            $user->getSubscriptionEndSerialized(),
            $user->getId(),
        ]);
    }
}
