<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\LabOrder;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class LabOrderSeeder extends Seeder
{
    public function run(): void
    {
        for ($order = 0; $order < 40; $order++) {
            LabOrder::factory()->create([
                'patient_id' => Patient::query()->inRandomOrder()->value('id'),
                'doctor_id' => Doctor::query()->inRandomOrder()->value('id'),
            ]);
        }
    }
}
