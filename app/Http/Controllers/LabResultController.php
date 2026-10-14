<?php

namespace App\Http\Controllers;

use App\Models\LabOrder;
use App\Models\LabResult;
use App\Models\LabTest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LabResultController extends Controller
{
    public function index(): View
    {
        $labResults = LabResult::with(['labOrder.patient', 'labTest'])
            ->latest('result_date')
            ->paginate(10);

        return view('lab-results.index', compact('labResults'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $labOrder = $request->filled('lab_order_id')
            ? LabOrder::findOrFail($request->integer('lab_order_id'))
            : null;

        if ($labOrder?->status === 'cancelled') {
            return redirect()->route('lab-orders.show', $labOrder)
                ->with('error', 'Results cannot be added to a cancelled order.');
        }

        return view('lab-results.create', [
            'labOrder' => $labOrder,
            'labOrders' => LabOrder::where('status', '!=', 'cancelled')->with('patient')->latest()->get(),
            'labTests' => LabTest::orderBy('test_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'lab_order_id' => ['required', 'exists:lab_orders,id'],
            'lab_test_id' => [
                'required',
                'exists:lab_tests,id',
                Rule::unique('lab_results')->where(fn ($query) => $query->where('lab_order_id', $request->input('lab_order_id'))),
            ],
            'result_value' => ['required', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:2000'],
            'result_date' => ['required', 'date'],
        ]);

        $labOrder = LabOrder::findOrFail($data['lab_order_id']);
        if ($labOrder->status === 'cancelled') {
            return back()->withInput()->with('error', 'Results cannot be added to a cancelled order.');
        }

        LabResult::create($data);

        return redirect()->route('lab-orders.show', $labOrder)->with('success', 'Lab result added successfully.');
    }

    public function show(LabResult $labResult): View
    {
        $labResult->load(['labOrder.patient', 'labOrder.doctor', 'labTest']);

        return view('lab-results.show', compact('labResult'));
    }

    public function edit(LabResult $labResult): View|RedirectResponse
    {
        $labResult->load('labOrder');
        if ($labResult->labOrder->status === 'cancelled') {
            return redirect()->route('lab-orders.show', $labResult->labOrder)
                ->with('error', 'Results cannot be edited for a cancelled order.');
        }

        return view('lab-results.edit', [
            'labResult' => $labResult,
            'labOrders' => LabOrder::where('status', '!=', 'cancelled')->with('patient')->latest()->get(),
            'labTests' => LabTest::orderBy('test_name')->get(),
        ]);
    }

    public function update(Request $request, LabResult $labResult): RedirectResponse
    {
        $data = $request->validate([
            'lab_order_id' => ['required', 'exists:lab_orders,id'],
            'lab_test_id' => [
                'required',
                'exists:lab_tests,id',
                Rule::unique('lab_results')
                    ->where(fn ($query) => $query->where('lab_order_id', $request->input('lab_order_id')))
                    ->ignore($labResult->id),
            ],
            'result_value' => ['required', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:2000'],
            'result_date' => ['required', 'date'],
        ]);

        $targetOrder = LabOrder::findOrFail($data['lab_order_id']);
        if ($targetOrder->status === 'cancelled') {
            return back()->withInput()->with('error', 'Results cannot be saved to a cancelled order.');
        }

        $labResult->update($data);

        return redirect()->route('lab-orders.show', $targetOrder)->with('success', 'Lab result updated successfully.');
    }

    public function destroy(LabResult $labResult): RedirectResponse
    {
        $orderId = $labResult->lab_order_id;
        $labResult->delete();

        return redirect()->route('lab-orders.show', $orderId)->with('success', 'Lab result deleted successfully.');
    }
}
