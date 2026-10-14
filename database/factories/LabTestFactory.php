<?php

namespace Database\Factories;

use App\Models\LabTest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LabTest>
 */
class LabTestFactory extends Factory
{
    protected $model = LabTest::class;

    public function definition(): array
    {
        [$testName, $category, $normalRange, $unit] = fake()->randomElement([
            ['CBC', 'Hematology', '4.0-11.0', '10^9/L'],
            ['Fasting Blood Sugar', 'Chemistry', '70-99', 'mg/dL'],
            ['Lipid Profile', 'Chemistry', 'Less than 200', 'mg/dL'],
            ['Urinalysis', 'Urinalysis', 'Clear, pale yellow', ''],
            ['Creatinine', 'Chemistry', '0.6-1.2', 'mg/dL'],
            ['Liver Function Panel', 'Chemistry', '7-56', 'U/L'],
            ['TSH', 'Immunology', '0.4-4.0', 'mIU/L'],
            ['Blood Typing', 'Hematology', 'A, B, AB, or O', ''],
        ]);

        return [
            'test_name' => $testName.' '.fake()->unique()->numerify('##'),
            'category' => $category,
            'price' => fake()->randomFloat(2, 150, 2500),
            'normal_range' => $normalRange,
            'unit' => $unit,
        ];
    }
}
