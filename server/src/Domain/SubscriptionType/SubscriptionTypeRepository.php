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

namespace App\Domain\SubscriptionType;

use PDO;

class SubscriptionTypeRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    /**
     * Retrieve all subscription types defined for this application
     *
     * @param  int  $limit  The limit of records to retrieve
     * @return SubscriptionType[]
     */
    public function all(int $limit = 10): array
    {
        $q = $this->pdo->prepare('SELECT * FROM subscription_types LIMIT ?');
        $q->execute([$limit]);

        return array_map(fn ($el) => SubscriptionType::mapFromArray($el), $q->fetchAll());
    }

    public function findOne(int $id): SubscriptionType|false
    {
        $q = $this->pdo->prepare('SELECT * FROM subscription_types WHERE id = ?');
        $q->execute([$id]);
        /** @var array<string, mixed>|false */
        $data = $q->fetch();

        return $data ? SubscriptionType::mapFromArray($data) : false;
    }

    public function create(SubscriptionType $st): void
    {
        $q = $this->pdo->prepare('INSERT INTO subscription_types (displayName) VALUES (?)');
        $q->execute([$st->getDisplayName()]);
    }

    public function edit(SubscriptionType $st): void
    {
        $q = $this->pdo->prepare('UPDATE subscription_types SET displayName = ? WHERE id = ?');
        $q->execute([$st->getDisplayName(), $st->getId()]);
    }
}
