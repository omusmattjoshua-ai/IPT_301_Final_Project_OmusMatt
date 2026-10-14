@extends('layouts.app')
@section('title', 'Add Doctor')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Add Doctor</h1></div>
        <div class="card-body">
            <form action="{{ route('doctors.store') }}" method="POST">
                @csrf @include('doctors._form')
                <button class="btn btn-primary">Save Doctor</button>
                <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
