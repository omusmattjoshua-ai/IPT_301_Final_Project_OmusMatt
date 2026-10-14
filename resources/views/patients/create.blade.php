@extends('layouts.app')
@section('title', 'Add Patient')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Add Patient</h1></div>
        <div class="card-body"><form action="{{ route('patients.store') }}" method="POST">
            @csrf @include('patients._form')
            <button class="btn btn-primary">Save Patient</button><a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form></div>
    </div>
@endsection
