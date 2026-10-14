@extends('layouts.app')
@section('title', 'Lab Orders')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Lab Orders</h1>
        <a href="{{ route('lab-orders.create') }}" class="btn btn-primary">Create Lab Order</a>
    </div>
    <div class="card border-0 shadow-sm"><div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Order</th><th>Patient</th><th>Doctor</th><th>Order date</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse ($labOrders as $labOrder)
                    <tr>
                        <td>#{{ $labOrder->id }}</td>
                        <td>{{ $labOrder->patient->first_name }} {{ $labOrder->patient->last_name }}</td>
                        <td>{{ $labOrder->doctor->name }}</td><td>{{ $labOrder->order_date->format('M j, Y') }}</td>
                        <td><span class="badge text-bg-{{ ['pending' => 'warning', 'in_progress' => 'info', 'completed' => 'success', 'cancelled' => 'secondary'][$labOrder->status] }}">{{ str_replace('_', ' ', ucfirst($labOrder->status)) }}</span></td>
                        <td class="text-nowrap">
                            <a href="{{ route('lab-orders.show', $labOrder) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('lab-orders.edit', $labOrder) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('lab-orders.destroy', $labOrder) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lab order and all of its results?');">
                                @csrf @method('DELETE') <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty <tr><td colspan="6" class="text-center text-secondary py-4">No lab orders found.</td></tr> @endforelse
            </tbody>
        </table>
    </div><div class="card-body">{{ $labOrders->links() }}</div></div>
@endsection
