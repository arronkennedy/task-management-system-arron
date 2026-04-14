@extends('layouts.app')
@section('title', 'New Category')
@section('content')
<h4 class="fw-bold mb-4">Create Category</h4>
<div class="card p-4" style="max-width:480px;">
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        @include('categories._form', ['category' => null])
        <button class="btn btn-primary">Create</button>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection