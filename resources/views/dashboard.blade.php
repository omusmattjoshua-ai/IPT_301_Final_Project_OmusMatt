@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h1 class="h3 mb-1">Laboratory Dashboard</h1>
            <p class="text-secondary mb-0">A current overview of the laboratory.</p>
        </div>
        <a href="{{ route('lab-orders.create') }}" class="btn btn-primary">Create Lab Order</a>
    </div>
    <div class="row g-3 mb-4">
        @foreach ([
            ['Patients', $patientCount, 'patients.index'],
            ['Doctors', $doctorCount, 'doctors.index'],
            ['Lab Tests', $labTestCount, 'lab-tests.index'],
            ['Lab Orders', $orderCount, 'lab-orders.index'],
            ['Pending Orders', $pendingOrderCount, 'lab-orders.index'],
        ] as [$label, $count, $route])
            <div class="col-6 col-lg">
                <a class="card h-100 text-decoration-none shadow-sm" href="{{ route($route) }}">
                    <div class="card-body">
                        <div class="small text-secondary">{{ $label }}</div>
                        <div class="display-6 fw-semibold text-primary">{{ $count }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Five Recent Lab Orders</h2>
            <a href="{{ route('lab-orders.index') }}" class="btn btn-sm btn-outline-primary">All orders</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Order</th><th>Patient</th><th>Doctor</th><th>Order date</th><th>Status</th><th></th></tr></thead>
                <tbody>
                    @forelse ($recentOrders as $labOrder)
                        <tr>
                            <td>#{{ $labOrder->id }}</td>
                            <td>{{ $labOrder->patient->first_name }} {{ $labOrder->patient->last_name }}</td>
                            <td>{{ $labOrder->doctor->name }}</td>
                            <td>{{ $labOrder->order_date->format('M j, Y') }}</td>
                            <td><span class="badge text-bg-{{ ['pending' => 'warning', 'in_progress' => 'info', 'completed' => 'success', 'cancelled' => 'secondary'][$labOrder->status] }}">{{ str_replace('_', ' ', ucfirst($labOrder->status)) }}</span></td>
                            <td><a href="{{ route('lab-orders.show', $labOrder) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-secondary py-4">No lab orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
