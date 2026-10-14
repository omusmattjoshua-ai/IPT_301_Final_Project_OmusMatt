<?php

namespace App\Http\Controllers;

use App\Models\LabTest;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LabTestController extends Controller
{
    public function index(): View
    {
        $labTests = LabTest::withCount('labResults')->orderBy('test_name')->paginate(10);

        return view('lab-tests.index', compact('labTests'));
    }

    public function create(): View
    {
        return view('lab-tests.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'test_name' => ['required', 'string', 'max:255', 'unique:lab_tests,test_name'],
            'category' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'normal_range' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
        ]);

        LabTest::create($data);

        return redirect()->route('lab-tests.index')->with('success', 'Lab test created successfully.');
    }

    public function show(LabTest $labTest): View
    {
        $labTest->load(['labResults.labOrder.patient', 'labResults.labOrder.doctor']);

        return view('lab-tests.show', compact('labTest'));
    }

    public function edit(LabTest $labTest): View
    {
        return view('lab-tests.edit', compact('labTest'));
    }

    public function update(Request $request, LabTest $labTest): RedirectResponse
    {
        $data = $request->validate([
            'test_name' => ['required', 'string', 'max:255', Rule::unique('lab_tests')->ignore($labTest)],
            'category' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'normal_range' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
        ]);

        $labTest->update($data);

        return redirect()->route('lab-tests.show', $labTest)->with('success', 'Lab test updated successfully.');
    }

    public function destroy(LabTest $labTest): RedirectResponse
    {
        try {
            $labTest->delete();
        } catch (QueryException $exception) {
            if (! $this->isForeignKeyConstraintViolation($exception)) {
                throw $exception;
            }

            return back()->with('error', 'This lab test cannot be deleted because it is part of a lab order.');
        }

        return redirect()->route('lab-tests.index')->with('success', 'Lab test deleted successfully.');
    }
}
