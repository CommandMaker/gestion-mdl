<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\SubscriptionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_create_subscription_type(): void
    {
        $this->loginAdminUser();

        $request = $this->post('/api/subscription-type/create', [
            'label' => 'Annuel',
            'price' => 10.00,
        ]);

        $request->assertStatus(201);
        $this->assertCount(1, SubscriptionType::all());
    }

    public function test_if_error_when_unauthorized_user(): void
    {
        $this->loginRandomUser();

        $request = $this->post('/api/subscription-type/create', [
            'label' => 'Annuel',
            'price' => 10.00,
        ]);

        $request->assertStatus(403);
        $this->assertCount(0, SubscriptionType::all());
    }

    public function test_if_error_when_unauthenticated(): void
    {
        $request = $this->post('/api/subscription-type/create', [
            'label' => 'Annuel',
            'price' => 10.00,
        ]);

        $request->assertStatus(403);
        $this->assertCount(0, SubscriptionType::all());
    }

    public function test_if_edit_correctly(): void
    {
        $user = $this->loginAdminUser();

        $st = SubscriptionType::factory()->create();

        $request = $this->patch('/api/subscription-type/edit/1', [
            'label' => 'Hello World',
        ]);

        $request->assertStatus(200);
        $this->assertEquals('Hello World', SubscriptionType::findOrFail(1)->label);
    }

    public function test_if_collection_security_works_when_unauthenticated(): void
    {
        $request = $this->get('/api/subscription-type/collection');

        $request->assertStatus(403);
    }

    public function test_if_collection_security_works_when_unauthorized(): void
    {
        $this->loginRandomUser();

        $request = $this->get('/api/subscription-type/collection');

        $request->assertStatus(403);
    }
}
