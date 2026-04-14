@extends('layouts.app')
@section('title', 'Edit Category')
@section('content')
<h4 class="fw-bold mb-4">Edit Category</h4>
<div class="card p-4" style="max-width:480px;">
    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf @method('PUT')
        @include('categories._form', ['category' => $category])
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection