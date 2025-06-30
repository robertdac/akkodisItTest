<?php

    namespace Database\Factories;

    use Illuminate\Database\Eloquent\Factories\Factory;
    use Illuminate\Support\Arr;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
     */
    class EmployeeFactory extends Factory
    {

        private static array $usedDocumentNumbers = [];

        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            return [
                'document_number' => $this->uniqueDocumentNumber(),
                'phone' => $this->faker->phoneNumber(),
                'address' => $this->faker->address(),
                'birth_date' => $this->faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
                'position' => $this->faker->jobTitle(),
                'department' => $this->faker->randomElement(['HR', 'IT', 'Finance', 'Logistics']),
                'hire_date' => $this->faker->date(),
                'status' => $this->faker->randomElement(['active', 'inactive']),
            ];
        }


        private function uniqueDocumentNumber(): string
        {

            $number = $this->faker->regexify('[A-HJ-NP-SUVW][0-9]{7}[0-9]');

            if (!in_array($number, self::$usedDocumentNumbers)) {

                self::$usedDocumentNumbers[] = $number;
                return $number;

            } else {

                return $this->uniqueDocumentNumber();
            }

        }
    }
