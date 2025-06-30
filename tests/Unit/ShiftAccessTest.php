<?php

    use App\Models\Employee;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;
    use App\Models\User;

    class ShiftAccessTest extends TestCase
    {
        use RefreshDatabase;

        public function test_non_authenticated_user_cannot_access_route()
        {
            $user = User::factory()->create();

            $response = $this->getJson("/api/v1/users/{$user->id}/shifts");

            $response->assertStatus(401);
        }

        public function test_non_admin_authenticated_user_cannot_access_route()
        {
            $user = User::factory()->create();
            $this->actingAs($user, 'sanctum');

            $response = $this->getJson("/api/v1/users/{$user->id}/shifts");

            $response->assertStatus(403);
        }

        public function test_admin_can_access_route()
        {
            $admin = User::factory()->create(['id' => 1]);
            Employee::factory()->create(['user_id' => $admin->id]);
            $this->actingAs($admin, 'sanctum');
            $response = $this->getJson("/api/v1/users/{$admin->id}/shifts?start=2025-04-19&end=2025-07-30");
            $response->assertStatus(200);
        }
    }
