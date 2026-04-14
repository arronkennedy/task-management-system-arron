@extends('layouts.app')
@section('title', $task->title)
@section('content')

<div class="mb-4">
    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<div class="card p-4" style="max-width:640px;">
    <h5 class="fw-bold mb-1">{{ $task->title }}</h5>
    @if($task->isOverdue())
        <span class="badge bg-danger mb-3">Overdue</span>
    @endif

    <p class="text-muted">{{ $task->description ?? 'No description.' }}</p>
    <hr>
    <div class="row g-3">
        <div class="col-6">
            <small class="text-muted d-block">Status</small>
            <strong>{{ ucfirst(str_replace('_',' ',$task->status)) }}</strong>
        </div>
        <div class="col-6">
            <small class="text-muted d-block">Priority</small>
            <strong>{{ ucfirst($task->priority) }}</strong>
        </div>
        <div class="col-6">
            <small class="text-muted d-block">Category</small>
            <strong>{{ $task->category?->name ?? '—' }}</strong>
        </div>
        <div class="col-6">
            <small class="text-muted d-block">Due Date</small>
            <strong>{{ $task->due_date?->format('d M Y') ?? '—' }}</strong>
        </div>
        @if($task->completed_at)
        <div class="col-6">
            <small class="text-muted d-block">Completed At</small>
            <strong>{{ $task->completed_at->format('d M Y H:i') }}</strong>
        </div>
        @endif
    </div>
    <hr>
    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Edit Task</a>
</div>
@endsection