@extends('layouts.app')
@section('title', $labTest->test_name)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $labTest->test_name }}</h1>
        <div><a href="{{ route('lab-tests.edit', $labTest) }}" class="btn btn-outline-primary">Edit Test</a><a href="{{ route('lab-tests.index') }}" class="btn btn-outline-secondary ms-2">Back</a></div>
    </div>
    <div class="card border-0 shadow-sm mb-4"><div class="card-body row g-3">
        <div class="col-md-4"><strong>Category:</strong> {{ $labTest->category }}</div>
        <div class="col-md-4"><strong>Price:</strong> {{ number_format((float) $labTest->price, 2) }}</div>
        <div class="col-md-4"><strong>Normal range:</strong> {{ $labTest->normal_range }} {{ $labTest->unit }}</div>
    </div></div>
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h2 class="h5 mb-0">Results for this test</h2></div>
        <div class="table-responsive"><table class="table mb-0"><thead><tr><th>Result</th><th>Patient</th><th>Doctor</th><th>Value</th><th>Date</th><th></th></tr></thead><tbody>
            @forelse ($labTest->labResults as $result)
                <tr><td>#{{ $result->id }}</td><td>{{ $result->labOrder->patient->first_name }} {{ $result->labOrder->patient->last_name }}</td><td>{{ $result->labOrder->doctor->name }}</td><td>{{ $result->result_value }}</td><td>{{ $result->result_date->format('M j, Y') }}</td><td><a href="{{ route('lab-results.show', $result) }}" class="btn btn-sm btn-outline-primary">View</a></td></tr>
            @empty <tr><td colspan="6" class="text-center text-secondary py-3">No results have used this test.</td></tr> @endforelse
        </tbody></table></div>
    </div>
@endsection
