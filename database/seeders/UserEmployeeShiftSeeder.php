<?php

    namespace Database\Seeders;

    use App\Models\Employee;
    use App\Models\Shift;
    use App\Models\User;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;

    class UserEmployeeShiftSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            User::factory(50)->create()->each(function($user) {
                $employee = $user->employee()->create(
                    Employee::factory()->make()->toArray()
                );

                Shift::factory(rand(3, 10))->create([
                    'employee_id' => $employee->id,
                ]);
            });
        }
    }
