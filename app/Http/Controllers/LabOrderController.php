<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\LabOrder;
use App\Models\LabResult;
use App\Models\LabTest;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LabOrderController extends Controller
{
    public function index(): View
    {
        $labOrders = LabOrder::with(['patient', 'doctor'])
            ->latest('order_date')
            ->paginate(10);

        return view('lab-orders.index', compact('labOrders'));
    }

    public function create(): View
    {
        return view('lab-orders.create', [
            'patients' => Patient::orderBy('last_name')->get(),
            'doctors' => Doctor::orderBy('name')->get(),
            'labTests' => LabTest::orderBy('test_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'order_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'remarks' => ['nullable', 'string', 'max:2000'],
            'lab_test_ids' => ['required', 'array', 'min:1'],
            'lab_test_ids.*' => ['required', 'integer', 'distinct', 'exists:lab_tests,id'],
        ]);

        $labOrder = DB::transaction(function () use ($data): LabOrder {
            $order = LabOrder::create(collect($data)->except('lab_test_ids')->all());
            $this->saveSelectedTests($order, $data['lab_test_ids']);

            return $order;
        });

        return redirect()->route('lab-orders.show', $labOrder)->with('success', 'Lab order created successfully.');
    }

    public function show(LabOrder $labOrder): View
    {
        $labOrder->load(['patient', 'doctor', 'labResults.labTest']);

        return view('lab-orders.show', compact('labOrder'));
    }

    public function edit(LabOrder $labOrder): View
    {
        $labOrder->load('labResults');

        return view('lab-orders.edit', [
            'labOrder' => $labOrder,
            'patients' => Patient::orderBy('last_name')->get(),
            'doctors' => Doctor::orderBy('name')->get(),
            'labTests' => LabTest::orderBy('test_name')->get(),
        ]);
    }

    public function update(Request $request, LabOrder $labOrder): RedirectResponse
    {
        $data = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'order_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'remarks' => ['nullable', 'string', 'max:2000'],
            'lab_test_ids' => ['required', 'array', 'min:1'],
            'lab_test_ids.*' => ['required', 'integer', 'distinct', 'exists:lab_tests,id'],
        ]);

        DB::transaction(function () use ($data, $labOrder): void {
            $labOrder->update(collect($data)->except('lab_test_ids')->all());
            $this->saveSelectedTests($labOrder, $data['lab_test_ids']);
        });

        return redirect()->route('lab-orders.show', $labOrder)->with('success', 'Lab order updated successfully.');
    }

    public function destroy(LabOrder $labOrder): RedirectResponse
    {
        $labOrder->delete();

        return redirect()->route('lab-orders.index')->with('success', 'Lab order and its results deleted successfully.');
    }

    private function saveSelectedTests(LabOrder $labOrder, array $labTestIds): void
    {
        $labOrder->labResults()->whereNotIn('lab_test_id', $labTestIds)->delete();

        foreach ($labTestIds as $labTestId) {
            LabResult::firstOrCreate(
                ['lab_order_id' => $labOrder->id, 'lab_test_id' => $labTestId],
                ['result_value' => 'Pending', 'result_date' => $labOrder->order_date],
            );
        }
    }
}
