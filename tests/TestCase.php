<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function createAdminUser(): User
    {
        return User::factory()->create([
            'is_admin' => true,
            'is_loggable' => true,
        ]);
    }

    protected function loginAdminUser(): User
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);

        return $user;
    }

    protected function loginRandomUser(): User
    {
        $user = User::factory()->create([
            'is_loggable' => true,
        ]);
        $this->actingAs($user);

        return $user;
    }
}
