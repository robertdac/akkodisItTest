<?php

    namespace Tests\Feature;

    use App\Models\User;
    use App\Models\Employee;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    class ShiftQueryTest extends TestCase
    {
        use RefreshDatabase;

        protected User $admin;
        protected Employee $employee;

        protected function setUp(): void
        {
            parent::setUp();

            $this->admin = User::factory()->create(['id' => 1]);
            $this->employee = Employee::factory()->create(['user_id' => $this->admin->id]);

            $this->employee->shifts()->delete();

            $this->employee->shifts()->createMany([
                [
                    'type' => 'work',
                    'start_date' => '2025-06-01',
                    'end_date' => '2025-06-02',
                ],
                [
                    'type' => 'off',
                    'start_date' => '2025-06-10',
                    'end_date' => '2025-06-11',
                ],
                [
                    'type' => 'work',
                    'start_date' => '2025-06-20',
                    'end_date' => '2025-06-21',
                ],
            ]);
        }

        public function test_requires_start_and_end_params()
        {
            $this->actingAs($this->admin, 'sanctum');

            $response = $this->getJson("/api/v1/users/{$this->admin->id}/shifts");

            $response->assertStatus(422);
            $response->assertJsonValidationErrors(['start', 'end']);
        }

        public function test_returns_all_shifts_within_range()
        {
            $this->actingAs($this->admin, 'sanctum');

            $response = $this->getJson("/api/v1/users/{$this->admin->id}/shifts?start=2025-06-01&end=2025-06-30");

            $response->assertStatus(200);
            $response->assertJsonCount(3, 'data');

            $data = $response->json('data');

            $this->assertEquals('01/06/2025', substr($data[0]['start_date'], 0, 10));
            $this->assertEquals('10/06/2025', substr($data[1]['start_date'], 0, 10));
            $this->assertEquals('20/06/2025', substr($data[2]['start_date'], 0, 10));
        }

        public function test_filters_by_fuel()
        {
            $this->actingAs($this->admin, 'sanctum');

            $response = $this->getJson("/api/v1/users/{$this->admin->id}/shifts?start=2025-06-01&end=2025-06-30&fuel=1");

            $response->assertStatus(200);
            $data = $response->json('data');

            $this->assertCount(2, $data);
            foreach ($data as $shift) {
                $this->assertEquals('Work', $shift['type']);
            }
        }

        public function test_returns_first_shift_only()
        {
            $this->actingAs($this->admin, 'sanctum');

            $response = $this->getJson("/api/v1/users/{$this->admin->id}/shifts?start=2025-06-01&end=2025-06-30&first=1");

            $response->assertStatus(200);

            $data = $response->json('data');
            $this->assertEquals('01/06/2025', substr($data['start_date'], 0, 10));
        }

        public function test_returns_last_shift_only()
        {
            $this->actingAs($this->admin, 'sanctum');

            $response = $this->getJson("/api/v1/users/{$this->admin->id}/shifts?start=2025-06-01&end=2025-06-30&last=1");

            $response->assertStatus(200);

            $data = $response->json('data');
            $this->assertEquals('20/06/2025', substr($data['start_date'], 0, 10));
        }
    }
