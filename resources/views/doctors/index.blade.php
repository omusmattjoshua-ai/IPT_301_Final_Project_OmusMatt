@extends('layouts.app')
@section('title', 'Doctors')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Doctors</h1>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add Doctor</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Name</th><th>Specialization</th><th>License</th><th>Contact</th><th>Email</th><th>Orders</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->name }}</td><td>{{ $doctor->specialization }}</td><td>{{ $doctor->license_number }}</td>
                            <td>{{ $doctor->contact_number }}</td><td>{{ $doctor->email }}</td><td>{{ $doctor->lab_orders_count }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this doctor? Doctors with lab orders cannot be deleted.');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-secondary py-4">No doctors found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body">{{ $doctors->links() }}</div>
    </div>
@endsection
