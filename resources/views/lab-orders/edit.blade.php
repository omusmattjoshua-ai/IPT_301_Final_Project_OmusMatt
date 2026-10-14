@extends('layouts.app')
@section('title', 'Edit Lab Order')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Edit Lab Order #{{ $labOrder->id }}</h1></div>
        <div class="card-body"><form action="{{ route('lab-orders.update', $labOrder) }}" method="POST">
            @csrf @method('PUT') @include('lab-orders._form')
            <button class="btn btn-primary">Update Lab Order</button><a href="{{ route('lab-orders.show', $labOrder) }}" class="btn btn-outline-secondary">Cancel</a>
        </form></div>
    </div>
@endsection
