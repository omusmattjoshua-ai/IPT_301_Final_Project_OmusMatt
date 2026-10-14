<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(): View
    {
        $doctors = Doctor::withCount('labOrders')->latest()->paginate(10);

        return view('doctors.index', compact('doctors'));
    }

    public function create(): View
    {
        return view('doctors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'specialization' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:255', 'unique:doctors,license_number'],
            'contact_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:doctors,email'],
        ]);

        Doctor::create($data);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function show(Doctor $doctor): View
    {
        $doctor->load(['labOrders.patient']);

        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor): View
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'specialization' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:255', Rule::unique('doctors')->ignore($doctor)],
            'contact_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('doctors')->ignore($doctor)],
        ]);

        $doctor->update($data);

        return redirect()->route('doctors.show', $doctor)->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        try {
            $doctor->delete();
        } catch (QueryException $exception) {
            if (! $this->isForeignKeyConstraintViolation($exception)) {
                throw $exception;
            }

            return back()->with('error', 'This doctor cannot be deleted because lab orders are linked to them.');
        }

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
