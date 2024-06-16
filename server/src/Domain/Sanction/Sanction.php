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

use App\Core\Entity\AbstractEntity;
use App\Core\Entity\EntityMapper;
use App\Core\Entity\HasRelations;
use App\Core\Entity\SerializableEntity;
use App\Domain\User\User;
use DateTimeImmutable;

class Sanction extends AbstractEntity
{
    use EntityMapper, HasRelations, SerializableEntity;

    public static string $tableName = 'sanctions';

    /** @var string[] */
    protected array $serializable = ['id', 'target', 'admin', 'dateIssued', 'message'];

    private int $id;

    private int $targetId;

    private DateTimeImmutable $dateIssued;

    private int $adminId;

    private string $message;

    /**
     * @return array<string, string>
     */
    protected function cast(): array
    {
        return [
            'dateIssued' => 'datetime:Y-m-d H:i:s',
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

    public function getTargetId(): int
    {
        return $this->targetId;
    }

    public function setTargetId(int $targetId): self
    {
        $this->targetId = $targetId;

        return $this;
    }

    public function getDateIssued(): DateTimeImmutable
    {
        return $this->dateIssued;
    }

    public function setDateIssued(string $dateIssued): self
    {
        $this->dateIssued = new DateTimeImmutable($dateIssued);

        return $this;
    }

    public function getAdminId(): int
    {
        return $this->adminId;
    }

    public function setAdminId(int $id): self
    {
        $this->adminId = $id;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getAdmin(): User
    {
        /** @phpstan-ignore-next-line */
        return $this->hasOne(User::class, 'adminId');
    }

    public function getTarget(): User
    {
        /** @phpstan-ignore-next-line */
        return $this->hasOne(User::class, 'targetId');
    }
}
