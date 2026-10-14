<?php

namespace Database\Seeders;

use App\Models\LabTest;
use Illuminate\Database\Seeder;

class LabTestSeeder extends Seeder
{
    public function run(): void
    {
        $tests = [
            ['CBC', 'Hematology', 450, '4.0-11.0', '10^9/L'],
            ['Fasting Blood Sugar', 'Chemistry', 250, '70-99', 'mg/dL'],
            ['Lipid Profile', 'Chemistry', 850, 'Less than 200', 'mg/dL'],
            ['Urinalysis', 'Urinalysis', 200, 'Clear, pale yellow', ''],
            ['Creatinine', 'Chemistry', 300, '0.6-1.2', 'mg/dL'],
            ['Blood Typing', 'Hematology', 350, 'A, B, AB, or O', ''],
            ['Liver Function Panel', 'Chemistry', 1200, '7-56', 'U/L'],
            ['Thyroid Stimulating Hormone', 'Immunology', 700, '0.4-4.0', 'mIU/L'],
            ['HbA1c', 'Chemistry', 650, 'Below 5.7', '%'],
            ['Electrolytes', 'Chemistry', 500, '135-145', 'mmol/L'],
            ['Pregnancy Test', 'Serology', 250, 'Negative', ''],
            ['C-Reactive Protein', 'Serology', 550, 'Below 10', 'mg/L'],
            ['Stool Examination', 'Parasitology', 300, 'No ova or parasites', ''],
            ['Dengue NS1', 'Serology', 900, 'Negative', ''],
            ['Prothrombin Time', 'Hematology', 600, '11-13.5', 'seconds'],
        ];

        foreach ($tests as [$name, $category, $price, $range, $unit]) {
            LabTest::create([
                'test_name' => $name,
                'category' => $category,
                'price' => $price,
                'normal_range' => $range,
                'unit' => $unit,
            ]);
        }
    }
}
