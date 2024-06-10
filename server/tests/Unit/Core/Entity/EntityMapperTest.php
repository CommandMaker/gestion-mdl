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

namespace Tests\Unit\Core\Entity;

use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

class EntityMapperTest extends TestCase
{
    public function testIfMapCorrectly(): void
    {
        $data = [
            'id' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'grade' => '1°4',
            'gender' => 'male',
            'code' => 'an01',
        ];

        $user = (new User())
            ->setId(1)
            ->setFirstname('John')
            ->setLastname('Doe')
            ->setGrade('1°4')
            ->setGender('male')
            ->setCode('an01');

        $this->assertEqualsCanonicalizing(User::mapFromArray($data), $user);
    }

    public function testIfIgnoreUnknownProperties(): void
    {
        $data = [
            'id' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'grade' => '1°4',
            'gender' => 'male',
            'code' => 'an01',
            'hello' => 'world',
        ];

        $user = (new User())
            ->setId(1)
            ->setFirstname('John')
            ->setLastname('Doe')
            ->setGrade('1°4')
            ->setGender('male')
            ->setCode('an01');

        $this->assertEqualsCanonicalizing(User::mapFromArray($data), $user);
    }
}
