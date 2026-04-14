@extends('layouts.app')
@section('title', 'Tasks')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tasks</h4>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>New Task
    </a>
</div>

<!-- Filters -->
<div class="card p-3 mb-4">
    <form method="GET" class="row g-2">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search..."
                   value="{{ $filters['search'] ?? '' }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                @foreach(['pending','in_progress','completed','cancelled'] as $s)
                <option value="{{ $s }}" {{ ($filters['status'] ?? '') == $s ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_',' ',$s)) }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="priority" class="form-select">
                <option value="">All Priority</option>
                @foreach(['low','medium','high','critical'] as $p)
                <option value="{{ $p }}" {{ ($filters['priority'] ?? '') == $p ? 'selected' : '' }}>
                    {{ ucfirst($p) }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="category_id" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-primary w-100">Filter</button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
        </div>
    </form>
</div>

<!-- Task Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Category</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr class="{{ $task->isOverdue() ? 'table-danger' : '' }}">
                    <td>{{ $tasks->firstItem() + $loop->index }}</td>
                    <td>
                        <a href="{{ route('tasks.show', $task) }}" class="fw-semibold text-decoration-none">
                            {{ $task->title }}
                        </a>
                        @if($task->isOverdue())
                            <span class="badge bg-danger ms-1">Overdue</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $sc = ['pending'=>'warning','in_progress'=>'info','completed'=>'success','cancelled'=>'secondary'];
                        @endphp
                        <span class="badge bg-{{ $sc[$task->status] ?? 'secondary' }}">
                            {{ ucfirst(str_replace('_',' ',$task->status)) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-priority-{{ $task->priority }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </td>
                    <td>
                        @if($task->category)
                            <span class="badge" style="background:{{ $task->category->color }}">
                                {{ $task->category->name }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $task->due_date?->format('d M Y') ?? '—' }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline"
                              onsubmit="return confirm('Delete this task?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No tasks found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $tasks->links() }}</div>
</div>
@endsection