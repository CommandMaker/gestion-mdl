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

use App\Domain\TimePeriod\TimePeriod;
use App\Domain\User\User;
use App\Http\TimePeriodController;
use PHPUnit\Framework\TestCase;

class SerializableEntityTest extends TestCase
{
    public function testIfSerializeCorrectlyUsingPropsParam(): void
    {
        $data = [
            'id' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
        ];

        $user = (new User())
            ->setId(1)
            ->setFirstname('John')
            ->setLastname('Doe')
            ->setGrade('1°4')
            ->setGender('male')
            ->setCode('an01');

        $this->assertSame($user->toArray(['id', 'firstname', 'lastname']), $data);
    }

    public function testIfSerializePropertyUsingSerializableProperty(): void
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

        $this->assertEqualsCanonicalizing($user->toArray(), $data);
    }

    public function testIfSerializeCorrectlyUsingSerializedGetter(): void
    {
        $data = [
            'id' => 1,
            'displayName' => '8h-9h',
            'startTime' => '07:55:00',
            'endTime' => '08:55:00'
        ];

        $timePeriod = (new TimePeriod())
            ->setId(1)
            ->setDisplayName('8h-9h')
            ->setStartTime('2024-06-10 07:55:00.000000')
            ->setEndTime('2024-06-10 08:55:00.000000');

        $this->assertSame($timePeriod->toArray(), $data);
    }
}
