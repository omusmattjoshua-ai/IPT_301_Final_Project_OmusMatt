@extends('layouts.app')
@section('title', 'Edit Patient')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Edit Patient</h1></div>
        <div class="card-body"><form action="{{ route('patients.update', $patient) }}" method="POST">
            @csrf @method('PUT') @include('patients._form')
            <button class="btn btn-primary">Update Patient</button><a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-secondary">Cancel</a>
        </form></div>
    </div>
@endsection
