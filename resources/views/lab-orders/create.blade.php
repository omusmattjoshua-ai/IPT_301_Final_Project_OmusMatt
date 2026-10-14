@extends('layouts.app')
@section('title', 'Create Lab Order')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Create Lab Order</h1></div>
        <div class="card-body"><form action="{{ route('lab-orders.store') }}" method="POST">
            @csrf @include('lab-orders._form')
            <button class="btn btn-primary">Save Lab Order</button><a href="{{ route('lab-orders.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form></div>
    </div>
@endsection
