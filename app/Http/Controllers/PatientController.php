<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(): View
    {
        $patients = Patient::withCount('labOrders')->latest()->paginate(10);

        return view('patients.index', compact('patients'));
    }

    public function create(): View
    {
        return view('patients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'max:30'],
            'contact_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:2000'],
            'email' => ['nullable', 'email', 'max:255', 'unique:patients,email'],
        ]);

        Patient::create($data);

        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient): View
    {
        $patient->load(['labOrders.doctor', 'labOrders.labResults.labTest']);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient): View
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'max:30'],
            'contact_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:2000'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('patients')->ignore($patient)],
        ]);

        $patient->update($data);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        try {
            $patient->delete();
        } catch (QueryException $exception) {
            if (! $this->isForeignKeyConstraintViolation($exception)) {
                throw $exception;
            }

            return back()->with('error', 'This patient cannot be deleted because lab orders are linked to them.');
        }

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
