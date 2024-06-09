<?php

namespace Tests\Unit\Core\Entity;

use App\Domain\User\User;
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
}
