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

namespace App\Domain\CardScan;

use PDO;

class CardScanRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    /**
     * Get all cards scans available for a specific date and period
     *
     * @return CardScan[]
     */
    public function all(string $date, int $timePeriod): array
    {
        $q = $this->pdo->prepare('SELECT * FROM card_scans WHERE timePeriodId = ? AND date LIKE ?');
        $q->execute([$timePeriod, "%{$date}%"]);

        return array_map(fn ($i) => CardScan::mapFromArray($i), $q->fetchAll());
    }
}
