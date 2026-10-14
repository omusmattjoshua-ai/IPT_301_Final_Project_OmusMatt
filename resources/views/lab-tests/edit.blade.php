@extends('layouts.app')
@section('title', 'Edit Lab Test')
@section('content')
    <div class="card border-0 shadow-sm"><div class="card-header bg-white"><h1 class="h4 mb-0">Edit Lab Test</h1></div>
        <div class="card-body"><form action="{{ route('lab-tests.update', $labTest) }}" method="POST">
            @csrf @method('PUT') @include('lab-tests._form')
            <button class="btn btn-primary">Update Lab Test</button><a href="{{ route('lab-tests.show', $labTest) }}" class="btn btn-outline-secondary">Cancel</a>
        </form></div>
    </div>
@endsection
