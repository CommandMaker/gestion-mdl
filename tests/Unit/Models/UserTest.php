<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_if_user_login_attribute_is_correct(): void
    {
        $user = User::factory()->make();

        $this->assertEquals($user->id . $user->login_code, $user->password);
    }
}
