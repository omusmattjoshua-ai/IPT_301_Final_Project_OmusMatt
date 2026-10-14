<?php

namespace Database\Factories;

use App\Models\LabOrder;
use App\Models\LabResult;
use App\Models\LabTest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LabResult>
 */
class LabResultFactory extends Factory
{
    protected $model = LabResult::class;

    public function definition(): array
    {
        return [
            'lab_order_id' => LabOrder::factory(),
            'lab_test_id' => LabTest::factory(),
            'result_value' => fake()->randomElement(['Within range', 'Negative', '4.8', '98', '6.2']),
            'remarks' => fake()->optional()->sentence(),
            'result_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}
