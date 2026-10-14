<?php

namespace Database\Seeders;

use App\Models\LabOrder;
use App\Models\LabResult;
use App\Models\LabTest;
use Illuminate\Database\Seeder;

class LabResultSeeder extends Seeder
{
    public function run(): void
    {
        $tests = LabTest::all();

        foreach (LabOrder::all() as $order) {
            $tests->random(random_int(2, 3))->each(function (LabTest $test) use ($order): void {
                LabResult::factory()->create([
                    'lab_order_id' => $order->id,
                    'lab_test_id' => $test->id,
                ]);
            });
        }
    }
}
