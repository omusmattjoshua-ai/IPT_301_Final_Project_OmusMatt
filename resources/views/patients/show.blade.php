@extends('layouts.app')
@section('title', $patient->first_name.' '.$patient->last_name)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $patient->first_name }} {{ $patient->last_name }}</h1>
        <div><a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-primary">Edit Patient</a><a href="{{ route('patients.index') }}" class="btn btn-outline-secondary ms-2">Back</a></div>
    </div>
    <div class="card border-0 shadow-sm mb-4"><div class="card-body row g-3">
        <div class="col-md-6"><strong>Date of birth:</strong> {{ $patient->birth_date->format('M j, Y') }}</div>
        <div class="col-md-6"><strong>Gender:</strong> {{ $patient->gender }}</div>
        <div class="col-md-6"><strong>Contact:</strong> {{ $patient->contact_number }}</div>
        <div class="col-md-6"><strong>Email:</strong> {{ $patient->email ?: '—' }}</div>
        <div class="col-12"><strong>Address:</strong> {{ $patient->address }}</div>
    </div></div>
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h2 class="h5 mb-0">Lab Orders</h2></div>
        <div class="table-responsive"><table class="table mb-0"><thead><tr><th>Order</th><th>Doctor</th><th>Date</th><th>Status</th><th></th></tr></thead><tbody>
            @forelse ($patient->labOrders as $order)
                <tr><td>#{{ $order->id }}</td><td>{{ $order->doctor->name }}</td><td>{{ $order->order_date->format('M j, Y') }}</td><td>{{ str_replace('_', ' ', ucfirst($order->status)) }}</td><td><a href="{{ route('lab-orders.show', $order) }}" class="btn btn-sm btn-outline-primary">View</a></td></tr>
            @empty <tr><td colspan="5" class="text-center text-secondary py-3">No lab orders for this patient.</td></tr> @endforelse
        </tbody></table></div>
    </div>
@endsection
