@extends('layouts.app')
@section('title', 'Add Lab Result')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Add Lab Result</h1></div>
        <div class="card-body"><form action="{{ route('lab-results.store') }}" method="POST">
            @csrf @include('lab-results._form')
            <button class="btn btn-primary">Save Result</button><a href="{{ isset($labOrder) ? route('lab-orders.show', $labOrder) : route('lab-results.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form></div>
    </div>
@endsection
