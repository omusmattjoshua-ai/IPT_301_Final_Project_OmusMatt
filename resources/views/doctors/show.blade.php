@extends('layouts.app')
@section('title', $doctor->name)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $doctor->name }}</h1>
        <div><a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-outline-primary">Edit Doctor</a><a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary ms-2">Back</a></div>
    </div>
    <div class="card border-0 shadow-sm mb-4"><div class="card-body row g-3">
        <div class="col-md-6"><strong>Specialization:</strong> {{ $doctor->specialization }}</div>
        <div class="col-md-6"><strong>License:</strong> {{ $doctor->license_number }}</div>
        <div class="col-md-6"><strong>Contact:</strong> {{ $doctor->contact_number }}</div>
        <div class="col-md-6"><strong>Email:</strong> {{ $doctor->email }}</div>
    </div></div>
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h2 class="h5 mb-0">Lab Orders</h2></div>
        <div class="table-responsive"><table class="table mb-0"><thead><tr><th>Order</th><th>Patient</th><th>Date</th><th>Status</th><th></th></tr></thead><tbody>
            @forelse ($doctor->labOrders as $order)
                <tr><td>#{{ $order->id }}</td><td>{{ $order->patient->first_name }} {{ $order->patient->last_name }}</td><td>{{ $order->order_date->format('M j, Y') }}</td><td>{{ str_replace('_', ' ', ucfirst($order->status)) }}</td><td><a href="{{ route('lab-orders.show', $order) }}" class="btn btn-sm btn-outline-primary">View</a></td></tr>
            @empty <tr><td colspan="5" class="text-center text-secondary py-3">No orders for this doctor.</td></tr> @endforelse
        </tbody></table></div>
    </div>
@endsection
