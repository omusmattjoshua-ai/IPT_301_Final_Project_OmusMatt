@extends('layouts.app')
@section('title', 'Lab Result #'.$labResult->id)
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Lab Result #{{ $labResult->id }}</h1>
        <div><a href="{{ route('lab-results.edit', $labResult) }}" class="btn btn-outline-primary">Edit Result</a><a href="{{ route('lab-orders.show', $labResult->labOrder) }}" class="btn btn-outline-secondary ms-2">Order</a></div>
    </div>
    <div class="card border-0 shadow-sm"><div class="card-body row g-3">
        <div class="col-md-6"><strong>Order:</strong> <a href="{{ route('lab-orders.show', $labResult->labOrder) }}">#{{ $labResult->lab_order_id }}</a></div>
        <div class="col-md-6"><strong>Patient:</strong> {{ $labResult->labOrder->patient->first_name }} {{ $labResult->labOrder->patient->last_name }}</div>
        <div class="col-md-6"><strong>Test:</strong> <a href="{{ route('lab-tests.show', $labResult->labTest) }}">{{ $labResult->labTest->test_name }}</a></div>
        <div class="col-md-6"><strong>Value:</strong> {{ $labResult->result_value }}</div>
        <div class="col-md-6"><strong>Result date:</strong> {{ $labResult->result_date->format('M j, Y') }}</div>
        <div class="col-md-6"><strong>Remarks:</strong> {{ $labResult->remarks ?: '—' }}</div>
    </div></div>
@endsection
