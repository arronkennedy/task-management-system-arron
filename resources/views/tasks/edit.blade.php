@extends('layouts.app')
@section('title', 'Edit Task')
@section('content')

<h4 class="fw-bold mb-4">Edit Task</h4>

<div class="card p-4" style="max-width:640px;">
    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf @method('PUT')
        @include('tasks._form', ['task' => $task])
        <button class="btn btn-primary">Update Task</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection