@extends('layouts.app')
@section('title', 'New Task')
@section('content')

<h4 class="fw-bold mb-4">Create New Task</h4>

<div class="card p-4" style="max-width:640px;">
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        @include('tasks._form', ['task' => null])
        <button class="btn btn-primary">Create Task</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection