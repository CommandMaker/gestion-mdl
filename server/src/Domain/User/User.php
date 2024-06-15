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

use App\Core\Entity\AbstractEntity;
use App\Core\Entity\EntityMapper;
use App\Core\Entity\HasRelations;
use App\Core\Entity\SerializableEntity;
use App\Domain\SubscriptionType\SubscriptionType;
use DateTimeImmutable;

class User extends AbstractEntity
{
    use EntityMapper, HasRelations, SerializableEntity;

    public static string $tableName = 'users';

    /**
     * The props used for serialization
     *
     * @var string[]
     */
    protected array $serializable = ['id', 'firstname', 'lastname', 'grade', 'code', 'gender', 'subscriptionType', 'subscriptionEnd', 'subscriptionValidity'];

    private int $id;

    private string $firstname;

    private string $lastname;

    private string $gender;

    private string $code;

    private string $grade;

    private int $subscriptionTypeId = 1;

    private ?DateTimeImmutable $subscriptionEnd = null;

    /**
     * @return array<string, string>
     */
    protected function cast(): array
    {
        return [
            'subscriptionEnd' => 'datetime:Y-m-d',
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

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

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

    public function getGrade(): string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getSubscriptionTypeId(): int
    {
        return $this->subscriptionTypeId;
    }

    public function setSubscriptionTypeId(int $id): self
    {
        $this->subscriptionTypeId = $id;

        return $this;
    }

    public function getSubscriptionType(): SubscriptionType
    {
        /** @phpstan-ignore-next-line */
        return $this->hasOne(SubscriptionType::class, 'subscriptionTypeId');
    }

    public function getSubscriptionEnd(): ?DateTimeImmutable
    {
        return $this->subscriptionEnd;
    }

    public function setSubscriptionEnd(?string $end): self
    {
        if ($end !== null && $end !== 'null') {
            $this->subscriptionEnd = new DateTimeImmutable($end);
        }

        return $this;
    }

    public function getSubscriptionValidity(): bool
    {
        return $this->subscriptionTypeId === 1 || ($this->getSubscriptionTypeId() !== 1 && $this->getSubscriptionEnd() !== null && $this->getSubscriptionEnd() > new DateTimeImmutable());
    }
}
