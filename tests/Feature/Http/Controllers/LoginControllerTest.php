<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_log_in_correctly(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
            'is_loggable' => true,
        ]);

        $request = $this->post('/api/login', [
            'id' => $user->id,
            'code' => $user->password,
        ]);

        $request->assertStatus(200);
        $this->assertTrue(Auth::check());
    }

    public function test_if_error_when_user_not_loggable(): void
    {
        $user = User::factory()->create();

        $request = $this->post('/api/login', [
            'id' => $user->id,
            'code' => $user->password,
        ]);

        $request->assertStatus(403);
        $this->assertFalse(Auth::check());
    }
}
