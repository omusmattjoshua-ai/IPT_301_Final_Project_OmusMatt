<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\LabOrder;
use App\Models\LabResult;
use App\Models\LabTest;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LaboratoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_five_domain_tables_have_the_required_columns(): void
    {
        $expectedColumns = [
            'doctors' => ['id', 'name', 'specialization', 'license_number', 'contact_number', 'email', 'created_at', 'updated_at'],
            'patients' => ['id', 'first_name', 'last_name', 'birth_date', 'gender', 'contact_number', 'address', 'email', 'created_at', 'updated_at'],
            'lab_tests' => ['id', 'test_name', 'category', 'price', 'normal_range', 'unit', 'created_at', 'updated_at'],
            'lab_orders' => ['id', 'patient_id', 'doctor_id', 'order_date', 'status', 'remarks', 'created_at', 'updated_at'],
            'lab_results' => ['id', 'lab_order_id', 'lab_test_id', 'result_value', 'remarks', 'result_date', 'created_at', 'updated_at'],
        ];

        foreach ($expectedColumns as $table => $columns) {
            $this->assertTrue(Schema::hasTable($table));
            $actualColumns = Schema::getColumnListing($table);
            sort($actualColumns);
            sort($columns);
            $this->assertSame($columns, $actualColumns, "Unexpected columns in {$table}.");
        }
    }

    public function test_dashboard_shows_database_counts_and_recent_orders(): void
    {
        $doctor = Doctor::factory()->create();
        $patient = Patient::factory()->create();
        LabTest::factory()->create();
        LabOrder::factory()->for($doctor)->for($patient)->create(['status' => 'pending']);

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Laboratory Dashboard')
            ->assertSee('Pending Orders')
            ->assertSee($patient->first_name);
    }

    public function test_all_resource_screens_render(): void
    {
        $doctor = Doctor::factory()->create();
        $patient = Patient::factory()->create();
        $labTest = LabTest::factory()->create();
        $order = LabOrder::factory()->for($doctor)->for($patient)->create(['status' => 'pending']);
        $result = LabResult::factory()->create([
            'lab_order_id' => $order->id,
            'lab_test_id' => $labTest->id,
        ]);

        foreach ([
            'doctors' => $doctor,
            'patients' => $patient,
            'lab-tests' => $labTest,
            'lab-orders' => $order,
            'lab-results' => $result,
        ] as $resource => $model) {
            $this->get(route($resource.'.index'))->assertOk();
            $this->get(route($resource.'.create'))->assertOk();
            $this->get(route($resource.'.show', $model))->assertOk();
            $this->get(route($resource.'.edit', $model))->assertOk();
        }
    }

    public function test_pagination_uses_plain_previous_and_next_links(): void
    {
        LabResult::factory(11)->create();

        $this->get(route('lab-results.index'))
            ->assertOk()
            ->assertSee('Previous')
            ->assertSee('Next')
            ->assertDontSee('‹')
            ->assertDontSee('›');
    }

    public function test_patient_can_be_created_viewed_updated_and_deleted(): void
    {
        $patientData = [
            'first_name' => 'Mina',
            'last_name' => 'Santos',
            'birth_date' => '1994-04-12',
            'gender' => 'Female',
            'contact_number' => '555-0101',
            'address' => '12 Clinic Street',
            'email' => 'mina@example.test',
        ];

        $this->post(route('patients.store'), $patientData)->assertRedirect(route('patients.index'));
        $patient = Patient::where('email', $patientData['email'])->firstOrFail();
        $this->get(route('patients.show', $patient))->assertOk()->assertSee('Mina Santos');

        $this->put(route('patients.update', $patient), [...$patientData, 'first_name' => 'Mina Rose'])
            ->assertRedirect(route('patients.show', $patient));
        $this->assertDatabaseHas('patients', ['id' => $patient->id, 'first_name' => 'Mina Rose']);

        $order = LabOrder::factory()->for($patient)->create();
        $this->delete(route('patients.destroy', $patient))->assertRedirect()->assertSessionHas('error');
        $order->delete();
        $this->delete(route('patients.destroy', $patient))->assertRedirect(route('patients.index'));
        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }

    public function test_patient_validation_rejects_duplicate_email_and_future_birth_date(): void
    {
        $patient = Patient::factory()->create(['email' => 'existing@example.test']);

        $this->from(route('patients.create'))
            ->post(route('patients.store'), [
                'first_name' => 'Future',
                'last_name' => 'Person',
                'birth_date' => now()->addDay()->toDateString(),
                'gender' => 'Female',
                'contact_number' => '555-0102',
                'address' => 'Test address',
                'email' => $patient->email,
            ])
            ->assertSessionHasErrors(['birth_date', 'email']);
    }

    public function test_invalid_doctor_lab_test_order_and_result_data_is_rejected(): void
    {
        $this->post(route('doctors.store'), [
            'name' => 'Dr. Valid Name',
            'specialization' => 'Hematology',
            'license_number' => 'MD-INVALID-EMAIL',
            'contact_number' => '555-0104',
            'email' => 'not-an-email',
        ])->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('doctors', ['license_number' => 'MD-INVALID-EMAIL']);

        $labTest = LabTest::factory()->create();
        $this->post(route('lab-tests.store'), [
            'test_name' => 'Invalid Price Test',
            'category' => 'Chemistry',
            'price' => '-1',
            'normal_range' => '4.0-11.0',
            'unit' => 'mmol/L',
        ])->assertSessionHasErrors('price');

        $this->assertDatabaseMissing('lab_tests', ['test_name' => 'Invalid Price Test']);

        $doctor = Doctor::factory()->create();
        $patient = Patient::factory()->create();
        $this->post(route('lab-orders.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'order_date' => now()->toDateString(),
            'status' => 'pending',
            'lab_test_ids' => [],
        ])->assertSessionHasErrors('lab_test_ids');

        $this->assertDatabaseMissing('lab_orders', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
        ]);

        $order = LabOrder::factory()->for($doctor)->for($patient)->create();
        $this->post(route('lab-results.store'), [
            'lab_order_id' => $order->id,
            'lab_test_id' => $labTest->id,
            'result_value' => '',
            'result_date' => now()->toDateString(),
        ])->assertSessionHasErrors('result_value');

        $this->assertDatabaseMissing('lab_results', [
            'lab_order_id' => $order->id,
            'lab_test_id' => $labTest->id,
        ]);
    }

    public function test_doctor_crud_and_delete_protection_for_used_doctor(): void
    {
        $doctorData = [
            'name' => 'Dr. Ada Flores',
            'specialization' => 'Hematology',
            'license_number' => 'MD-ABC123',
            'contact_number' => '555-0103',
            'email' => 'ada@example.test',
        ];
        $this->post(route('doctors.store'), $doctorData)->assertRedirect(route('doctors.index'));
        $doctor = Doctor::where('license_number', $doctorData['license_number'])->firstOrFail();
        $this->get(route('doctors.show', $doctor))->assertOk()->assertSee('Dr. Ada Flores');
        $this->put(route('doctors.update', $doctor), [...$doctorData, 'specialization' => 'Clinical Pathology'])
            ->assertRedirect(route('doctors.show', $doctor));

        $patient = Patient::factory()->create();
        LabOrder::factory()->for($doctor)->for($patient)->create();
        $this->delete(route('doctors.destroy', $doctor))
            ->assertRedirect()
            ->assertSessionHas('error');
        $this->assertDatabaseHas('doctors', ['id' => $doctor->id]);

        LabOrder::query()->where('doctor_id', $doctor->id)->delete();
        $this->delete(route('doctors.destroy', $doctor))->assertRedirect(route('doctors.index'));
        $this->assertDatabaseMissing('doctors', ['id' => $doctor->id]);
    }

    public function test_lab_test_crud_validation_and_delete_protection(): void
    {
        $testData = [
            'test_name' => 'CBC Basic',
            'category' => 'Hematology',
            'price' => '450.00',
            'normal_range' => '4.0-11.0',
            'unit' => '10^9/L',
        ];
        $this->post(route('lab-tests.store'), $testData)->assertRedirect(route('lab-tests.index'));
        $labTest = LabTest::where('test_name', $testData['test_name'])->firstOrFail();
        $this->get(route('lab-tests.show', $labTest))->assertOk()->assertSee('CBC Basic');
        $this->put(route('lab-tests.update', $labTest), [...$testData, 'price' => '475.00'])
            ->assertRedirect(route('lab-tests.show', $labTest));

        $doctor = Doctor::factory()->create();
        $patient = Patient::factory()->create();
        $order = LabOrder::factory()->for($doctor)->for($patient)->create(['status' => 'pending']);
        $labResult = LabResult::factory()->create(['lab_order_id' => $order->id, 'lab_test_id' => $labTest->id]);
        $this->delete(route('lab-tests.destroy', $labTest))
            ->assertRedirect()
            ->assertSessionHas('error');
        $this->assertDatabaseHas('lab_tests', ['id' => $labTest->id]);
        $this->get(route('lab-results.show', $labResult))->assertOk();
        $this->get(route('lab-results.edit', $labResult))->assertOk();
        $this->delete(route('lab-results.destroy', $labResult))->assertRedirect(route('lab-orders.show', $order));
        $this->delete(route('lab-tests.destroy', $labTest))->assertRedirect(route('lab-tests.index'));
        $this->assertDatabaseMissing('lab_tests', ['id' => $labTest->id]);
    }

    public function test_lab_order_creates_results_and_deleting_order_cascades_them(): void
    {
        $patient = Patient::factory()->create();
        $doctor = Doctor::factory()->create();
        $tests = LabTest::factory(2)->create();

        $this->post(route('lab-orders.store'), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'order_date' => now()->toDateString(),
            'status' => 'pending',
            'lab_test_ids' => $tests->modelKeys(),
        ])->assertRedirect();

        $order = LabOrder::with('labResults')->firstOrFail();
        $this->assertCount(2, $order->labResults);
        $this->assertSame('Pending', $order->labResults->first()->result_value);
        $this->get(route('lab-orders.show', $order))->assertOk()->assertSee('Add Result');
        $this->get(route('lab-orders.edit', $order))->assertOk();
        $this->put(route('lab-orders.update', $order), [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'order_date' => now()->toDateString(),
            'status' => 'in_progress',
            'lab_test_ids' => $tests->modelKeys(),
        ])->assertRedirect(route('lab-orders.show', $order));

        $result = $order->labResults->first();
        $this->put(route('lab-results.update', $result), [
            'lab_order_id' => $order->id,
            'lab_test_id' => $result->lab_test_id,
            'result_value' => 'Within range',
            'result_date' => now()->toDateString(),
            'remarks' => 'Reviewed by the lab.',
        ])->assertRedirect(route('lab-orders.show', $order));
        $this->assertDatabaseHas('lab_results', ['id' => $result->id, 'result_value' => 'Within range']);

        $additionalTest = LabTest::factory()->create();
        $this->post(route('lab-results.store'), [
            'lab_order_id' => $order->id,
            'lab_test_id' => $additionalTest->id,
            'result_value' => 'Negative',
            'result_date' => now()->toDateString(),
            'remarks' => 'No abnormal findings.',
        ])->assertRedirect(route('lab-orders.show', $order));
        $additionalResult = LabResult::where('lab_test_id', $additionalTest->id)->firstOrFail();
        $this->get(route('lab-results.show', $additionalResult))->assertOk()->assertSee('Negative');
        $this->delete(route('lab-results.destroy', $additionalResult))
            ->assertRedirect(route('lab-orders.show', $order));

        $this->delete(route('lab-orders.destroy', $order))->assertRedirect(route('lab-orders.index'));
        $this->assertDatabaseMissing('lab_orders', ['id' => $order->id]);
        $this->assertDatabaseMissing('lab_results', ['lab_order_id' => $order->id]);
    }

    public function test_cancelled_orders_cannot_receive_results(): void
    {
        $order = LabOrder::factory()->create(['status' => 'cancelled']);
        $labTest = LabTest::factory()->create();

        $this->get(route('lab-results.create', ['lab_order_id' => $order->id]))
            ->assertRedirect(route('lab-orders.show', $order))
            ->assertSessionHas('error');

        $this->post(route('lab-results.store'), [
            'lab_order_id' => $order->id,
            'lab_test_id' => $labTest->id,
            'result_value' => 'Negative',
            'result_date' => now()->toDateString(),
        ])->assertRedirect()->assertSessionHas('error');
        $this->assertDatabaseMissing('lab_results', ['lab_order_id' => $order->id]);
    }
}
