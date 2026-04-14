@extends('layouts.app')
@section('title', 'Categories')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Categories</h4>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>New Category
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>No</th><th>Color</th><th>Name</th><th>Description</th><th>Tasks</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        <span style="width:24px;height:24px;border-radius:4px;background:{{ $category->color }};display:inline-block;"></span>
                    </td>
                    <td>{{ $category->name }}</td>
                    <td class="text-muted">{{ Str::limit($category->description, 60) }}</td>
                    <td><span class="badge bg-secondary">{{ $category->tasks_count }}</span></td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline"
                              onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $categories->links() }}</div>
</div>
@endsection