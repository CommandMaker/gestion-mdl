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

use App\Core\Entity\AbstractEntity;
use App\Core\Entity\EntityMapper;
use App\Core\Entity\HasRelations;
use App\Core\Entity\SerializableEntity;
use App\Domain\User\User;
use DateTimeImmutable;

class CardScan extends AbstractEntity
{
    use EntityMapper, HasRelations, SerializableEntity;

    public static string $tableName = 'card_scans';

    /**
     * @var string[]
     */
    protected array $serializable = ['code', 'date', 'timePeriodId', 'user'];

    private int $id;

    private string $code;

    private DateTimeImmutable $date;

    private int $timePeriodId;

    /**
     * @return array<string, string>
     */
    public function cast(): array
    {
        return [
            'date' => 'datetime:Y-m-d',
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = new DateTimeImmutable($date);

        return $this;
    }

    public function getTimePeriodId(): int
    {
        return $this->timePeriodId;
    }

    public function setTimePeriodId(int $id): self
    {
        $this->timePeriodId = $id;

        return $this;
    }

    public function getUser(): User
    {
        /** @phpstan-ignore-next-line */
        return $this->hasOne(User::class, 'code', 'code');
    }
}
