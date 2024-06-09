<?php

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
