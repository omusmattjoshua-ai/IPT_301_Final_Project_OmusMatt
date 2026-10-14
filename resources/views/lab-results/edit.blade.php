@extends('layouts.app')
@section('title', 'Edit Lab Result')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Edit Lab Result</h1></div>
        <div class="card-body"><form action="{{ route('lab-results.update', $labResult) }}" method="POST">
            @csrf @method('PUT') @include('lab-results._form')
            <button class="btn btn-primary">Update Result</button><a href="{{ route('lab-orders.show', $labResult->labOrder) }}" class="btn btn-outline-secondary">Cancel</a>
        </form></div>
    </div>
@endsection
