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

use App\Core\Entity\PropertySerializer;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PropertySerializerTest extends TestCase
{
    public function testIfSerializePrimitiveTypes(): void
    {
        $a = 'hello';
        $b = 1;
        $c = 1.5;
        $d = true;
        $e = null;
        $s = new PropertySerializer();

        $this->assertSame($s->serialize($a), $a);
        $this->assertSame($s->serialize($b), $b);
        $this->assertSame($s->serialize($c), $c);
        $this->assertSame($s->serialize($d), $d);
        $this->assertSame($s->serialize($e), $e);
    }

    public function testIfSerializeBasicObjectsToArray(): void
    {
        $s = new PropertySerializer();

        $a = [
            'a' => 'hello',
            'b' => 'world',
            'c' => false,
        ];

        $this->assertSame($s->serialize((object) $a), $a);
    }

    public function testIfSerializeComplexObjectsToArray(): void
    {
        $s = new PropertySerializer();

        $data = [
            'id' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'grade' => '1°4',
            'gender' => 'male',
            'code' => 'an01',
            'dateTime' => new DateTimeImmutable('18-06-2024'),
        ];

        $expected = [
            'id' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'grade' => '1°4',
            'gender' => 'male',
            'code' => 'an01',
            'dateTime' => '2024-06-18',
        ];

        $given = [];

        foreach ($data as $key => $value) {
            $given[$key] = $s->serialize($value, $key === 'dateTime' ? 'datetime:Y-m-d' : null);
        }

        $this->assertEqualsCanonicalizing($given, $expected);
    }

    public function testIfSerializeComplexObjectsToArrayWhenCastWithMultipleSeparators(): void
    {
        $s = new PropertySerializer();

        $data = [
            'id' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'grade' => '1°4',
            'gender' => 'male',
            'code' => 'an01',
            'dateTime' => new DateTimeImmutable('18-06-2024 04:55:00'),
        ];

        $expected = [
            'id' => 1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'grade' => '1°4',
            'gender' => 'male',
            'code' => 'an01',
            'dateTime' => '04:55:00',
        ];

        $given = [];

        foreach ($data as $key => $value) {
            $given[$key] = $s->serialize($value, $key === 'dateTime' ? 'datetime:H:i:s' : null);
        }

        $this->assertEqualsCanonicalizing($given, $expected);
    }
}
