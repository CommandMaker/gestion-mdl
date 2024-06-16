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

namespace App\Domain\Sanction;

use PDO;

class SanctionRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    /**
     * @return Sanction[]
     */
    public function all(int $id, int $limit = 10): array
    {
        $q = $this->pdo->prepare('SELECT * FROM sanctions WHERE targetId = ? LIMIT ?');
        $q->execute([$id, $limit]);

        return array_map(fn ($el) => Sanction::mapFromArray($el), $q->fetchAll());
    }

    public function create(Sanction $sanction): void
    {
        $q = $this->pdo->prepare('INSERT INTO sanctions (targetId, dateIssued, adminId, message) VALUES (?, ?, ?, ?)');
        $q->execute(array_values($sanction->toArray(['targetId', 'dateIssued', 'adminId', 'message'])));
    }
}
