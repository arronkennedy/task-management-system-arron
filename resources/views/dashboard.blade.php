@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<h4 class="fw-bold mb-4">Dashboard</h4>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    @foreach([
        ['label'=>'Total Tasks',  'value'=>$stats['total'],      'icon'=>'list-task',    'color'=>'primary'],
        ['label'=>'Pending',      'value'=>$stats['pending'],    'icon'=>'hourglass',    'color'=>'warning'],
        ['label'=>'In Progress',  'value'=>$stats['in_progress'],'icon'=>'play-circle',  'color'=>'info'],
        ['label'=>'Completed',    'value'=>$stats['completed'],  'icon'=>'check-circle', 'color'=>'success'],
        ['label'=>'Overdue',      'value'=>$stats['overdue'],    'icon'=>'exclamation-triangle','color'=>'danger'],
        ['label'=>'Critical',     'value'=>$stats['critical'],   'icon'=>'fire',         'color'=>'dark'],
    ] as $stat)
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card p-3 text-center">
            <i class="bi bi-{{ $stat['icon'] }} text-{{ $stat['color'] }} fs-3 mb-1"></i>
            <div class="fw-bold fs-4">{{ $stat['value'] }}</div>
            <div class="text-muted small">{{ $stat['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<!-- Completion Rate -->
<div class="card p-4 mb-4">
    <h6 class="fw-semibold mb-2">Completion Rate</h6>
    <div class="progress" style="height:20px;">
        <div class="progress-bar bg-success" style="width:{{ $completionRate }}%">
            {{ $completionRate }}%
        </div>
    </div>
</div>

<!-- Categories Overview -->
<div class="card p-4">
    <h6 class="fw-semibold mb-3">Categories</h6>
    @forelse($categories as $cat)
    <div class="d-flex align-items-center mb-2">
        <span class="me-2" style="width:14px;height:14px;border-radius:50%;background:{{ $cat->color }};display:inline-block;"></span>
        <span class="flex-grow-1">{{ $cat->name }}</span>
        <span class="badge bg-secondary">{{ $cat->tasks_count }} tasks</span>
    </div>
    @empty
    <p class="text-muted">No categories yet.</p>
    @endforelse
</div>

@endsection