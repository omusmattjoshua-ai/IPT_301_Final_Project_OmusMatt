@extends('layouts.app')
@section('title', 'Lab Order #'.$labOrder->id)
@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h1 class="h3 mb-0">Lab Order #{{ $labOrder->id }}</h1>
        <div>
            <a href="{{ route('lab-orders.edit', $labOrder) }}" class="btn btn-outline-primary">Edit Order</a>
            <a href="{{ route('lab-orders.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
    <div class="card border-0 shadow-sm mb-4"><div class="card-body row g-3">
        <div class="col-md-6"><strong>Patient:</strong> <a href="{{ route('patients.show', $labOrder->patient) }}">{{ $labOrder->patient->first_name }} {{ $labOrder->patient->last_name }}</a></div>
        <div class="col-md-6"><strong>Doctor:</strong> <a href="{{ route('doctors.show', $labOrder->doctor) }}">{{ $labOrder->doctor->name }}</a></div>
        <div class="col-md-6"><strong>Order date:</strong> {{ $labOrder->order_date->format('M j, Y') }}</div>
        <div class="col-md-6"><strong>Status:</strong> <span class="badge text-bg-{{ ['pending' => 'warning', 'in_progress' => 'info', 'completed' => 'success', 'cancelled' => 'secondary'][$labOrder->status] }}">{{ str_replace('_', ' ', ucfirst($labOrder->status)) }}</span></div>
        <div class="col-12"><strong>Remarks:</strong> {{ $labOrder->remarks ?: '—' }}</div>
    </div></div>
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h2 class="h5 mb-0">Requested Tests and Results</h2></div>
        <div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Test</th><th>Category</th><th>Price</th><th>Result</th><th>Result date</th><th>Remarks</th><th>Actions</th></tr></thead><tbody>
            @forelse ($labOrder->labResults as $result)
                <tr>
                    <td>{{ $result->labTest->test_name }}</td><td>{{ $result->labTest->category }}</td><td>{{ number_format((float) $result->labTest->price, 2) }}</td>
                    <td>{{ $result->result_value }}</td><td>{{ $result->result_date->format('M j, Y') }}</td><td>{{ $result->remarks ?: '—' }}</td>
                    <td class="text-nowrap">
                        @if ($labOrder->status !== 'cancelled')
                            <a href="{{ route('lab-results.edit', $result) }}" class="btn btn-sm btn-outline-secondary">{{ $result->result_value === 'Pending' ? 'Add Result' : 'Edit Result' }}</a>
                        @endif
                        <form action="{{ route('lab-results.destroy', $result) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this result?');">
                            @csrf @method('DELETE') <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty <tr><td colspan="7" class="text-center text-secondary py-4">No tests are attached to this order.</td></tr> @endforelse
        </tbody></table></div>
    </div>
@endsection
