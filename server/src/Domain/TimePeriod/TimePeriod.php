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

namespace App\Domain\TimePeriod;

use App\Core\Entity\EntityMapper;
use App\Core\Entity\SerializableEntity;
use DateTimeImmutable;

class TimePeriod
{
    use EntityMapper, SerializableEntity;

    /**
     * @var string[]
     */
    private array $serializable = ['id', 'displayName', 'startTime', 'endTime'];

    private int $id;

    private string $displayName;

    private DateTimeImmutable $startTime;

    private DateTimeImmutable $endTime;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getStartTime(): DateTimeImmutable
    {
        return $this->startTime;
    }

    public function setStartTime(string $startTime): self
    {
        $this->startTime = new DateTimeImmutable($startTime);

        return $this;
    }

    public function getStartTimeSerialized(): string
    {
        return $this->startTime->format('H:i:s');
    }

    public function getEndTime(): DateTimeImmutable
    {
        return $this->endTime;
    }

    public function setEndTime(string $endTime): self
    {
        $this->endTime = new DateTimeImmutable($endTime);

        return $this;
    }

    public function getEndTimeSerialized(): string
    {
        return $this->endTime->format('H:i:s');
    }
}
