@extends('layouts.app')
@section('title', 'Lab Tests')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Lab Tests</h1>
        <a href="{{ route('lab-tests.create') }}" class="btn btn-primary">Add Lab Test</a>
    </div>
    <div class="card border-0 shadow-sm"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Test</th><th>Category</th><th>Price</th><th>Normal range</th><th>Unit</th><th>Results</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse ($labTests as $labTest)
                    <tr>
                        <td>{{ $labTest->test_name }}</td><td>{{ $labTest->category }}</td><td>{{ number_format((float) $labTest->price, 2) }}</td>
                        <td>{{ $labTest->normal_range }}</td><td>{{ $labTest->unit ?: '—' }}</td><td>{{ $labTest->lab_results_count }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('lab-tests.show', $labTest) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('lab-tests.edit', $labTest) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('lab-tests.destroy', $labTest) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lab test? Tests used in orders cannot be deleted.');">
                                @csrf @method('DELETE') <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty <tr><td colspan="7" class="text-center text-secondary py-4">No lab tests found.</td></tr> @endforelse
            </tbody>
        </table>
    </div><div class="card-body">{{ $labTests->links() }}</div></div>
@endsection
