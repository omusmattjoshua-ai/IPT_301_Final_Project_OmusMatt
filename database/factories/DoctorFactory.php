<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'specialization' => fake()->randomElement([
                'Hematology',
                'Clinical Pathology',
                'Internal Medicine',
                'Family Medicine',
                'Pediatrics',
            ]),
            'license_number' => fake()->unique()->numerify('MD-######'),
            'contact_number' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
