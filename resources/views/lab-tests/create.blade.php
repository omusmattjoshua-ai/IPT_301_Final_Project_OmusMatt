@extends('layouts.app')
@section('title', 'Add Lab Test')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Add Lab Test</h1></div>
        <div class="card-body"><form action="{{ route('lab-tests.store') }}" method="POST">
            @csrf @include('lab-tests._form')
            <button class="btn btn-primary">Save Lab Test</button><a href="{{ route('lab-tests.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form></div>
    </div>
@endsection
