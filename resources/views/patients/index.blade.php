@extends('layouts.app')
@section('title', 'Patients')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Patients</h1>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Add Patient</a>
    </div>
    <div class="card border-0 shadow-sm"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Name</th><th>Date of birth</th><th>Gender</th><th>Contact</th><th>Email</th><th>Orders</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse ($patients as $patient)
                    <tr>
                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td><td>{{ $patient->birth_date->format('M j, Y') }}</td><td>{{ $patient->gender }}</td>
                        <td>{{ $patient->contact_number }}</td><td>{{ $patient->email ?: '—' }}</td><td>{{ $patient->lab_orders_count }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this patient? Patients with lab orders cannot be deleted.');">
                                @csrf @method('DELETE') <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty <tr><td colspan="7" class="text-center text-secondary py-4">No patients found.</td></tr> @endforelse
            </tbody>
        </table>
    </div><div class="card-body">{{ $patients->links() }}</div></div>
@endsection
