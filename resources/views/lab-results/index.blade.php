@extends('layouts.app')
@section('title', 'Lab Results')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Lab Results</h1>
        <a href="{{ route('lab-results.create') }}" class="btn btn-primary">Add Result</a>
    </div>
    <div class="card border-0 shadow-sm"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Result</th><th>Patient</th><th>Order</th><th>Test</th><th>Value</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse ($labResults as $labResult)
                    <tr>
                        <td>#{{ $labResult->id }}</td><td>{{ $labResult->labOrder->patient->first_name }} {{ $labResult->labOrder->patient->last_name }}</td>
                        <td><a href="{{ route('lab-orders.show', $labResult->labOrder) }}">#{{ $labResult->lab_order_id }}</a></td>
                        <td>{{ $labResult->labTest->test_name }}</td><td>{{ $labResult->result_value }}</td><td>{{ $labResult->result_date->format('M j, Y') }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('lab-results.show', $labResult) }}" class="btn btn-sm btn-outline-primary">View</a>
                            @if ($labResult->labOrder->status !== 'cancelled')
                                <a href="{{ route('lab-results.edit', $labResult) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            @endif
                            <form action="{{ route('lab-results.destroy', $labResult) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lab result?');">
                                @csrf @method('DELETE') <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty <tr><td colspan="7" class="text-center text-secondary py-4">No lab results found.</td></tr> @endforelse
            </tbody>
        </table>
    </div><div class="card-body">{{ $labResults->links() }}</div></div>
@endsection
