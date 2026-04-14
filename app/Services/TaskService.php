<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TaskService
{
    /**
     * Get paginated tasks with optional filters.
     */
    public function getFilteredTasks(array $filters = []): LengthAwarePaginator
    {
        $query = Task::with('category')
            ->orderByRaw("
                CASE status
                    WHEN 'pending' THEN 1
                    WHEN 'in_progress' THEN 2
                    WHEN 'completed' THEN 3
                    WHEN 'cancelled' THEN 4
                END
            ")
            ->orderBy('due_date', 'asc');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->paginate(10)->withQueryString();
    }

    /**
     * Create a new task after validating business rules.
     */
    public function createTask(array $data): Task
    {
        $this->validateDueDate($data['due_date'] ?? null);

        return Task::create($data);
    }

    /**
     * Update an existing task.
     */
    public function updateTask(Task $task, array $data): Task
    {
        $this->validateDueDate($data['due_date'] ?? null);

        // Auto-set completed_at when status changes to completed
        if (isset($data['status']) && $data['status'] === 'completed' && !$task->isCompleted()) {
            $data['completed_at'] = now();
        }

        // Clear completed_at if task is re-opened
        if (isset($data['status']) && $data['status'] !== 'completed') {
            $data['completed_at'] = null;
        }

        $task->update($data);
        return $task->fresh();
    }

    /**
     * Delete a task (only if not completed).
     */
    public function deleteTask(Task $task): bool
    {
        if ($task->isCompleted()) {
            throw new \Exception('Completed tasks cannot be deleted.');
        }

        return $task->delete();
    }

    /**
     * Get summary statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total'       => Task::count(),
            'pending'     => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed'   => Task::where('status', 'completed')->count(),
            'cancelled'   => Task::where('status', 'cancelled')->count(),
            'overdue'     => Task::overdue()->count(),
            'critical'    => Task::where('priority', 'critical')
                                 ->whereNotIn('status', ['completed', 'cancelled'])
                                 ->count(),
        ];
    }

    /**
     * Calculate completion rate (0–100).
     */
    public function getCompletionRate(): float
    {
        $total = Task::count();
        if ($total === 0) {
            return 0.0;
        }
        $completed = Task::where('status', 'completed')->count();
        return round(($completed / $total) * 100, 2);
    }

    // ──────────── Private Helpers ────────────

    private function validateDueDate(?string $dueDate): void
    {
        if ($dueDate && $dueDate < now()->toDateString()) {
            throw new \InvalidArgumentException('Due date cannot be in the past.');
        }
    }
}