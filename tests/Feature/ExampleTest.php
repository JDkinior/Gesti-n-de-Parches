<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that unauthenticated user is redirected to login from root.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /**
     * Test that authenticated user is redirected to dashboard from root.
     */
    public function test_authenticated_user_redirected_to_dashboard(): void
    {
        $response = $this->actingAs($this->createTestUser())->get('/');

        $response->assertRedirect('/dashboard');
    }

    private function createTestUser()
    {
        return \App\Models\User::factory()->create();
    }
}
