@extends('layouts.app')
@section('title', 'Edit Doctor')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Edit Doctor</h1></div>
        <div class="card-body">
            <form action="{{ route('doctors.update', $doctor) }}" method="POST">
                @csrf @method('PUT') @include('doctors._form')
                <button class="btn btn-primary">Update Doctor</button>
                <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
