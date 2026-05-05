<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Category;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService) {}

    public function index(Request $request)
    {
        $filters    = $request->only(['status', 'priority', 'category_id', 'search']);
        $tasks      = $this->taskService->getFilteredTasks($filters);
        $categories = Category::all();

        return view('tasks.indexxx', compact('tasks', 'categories', 'filters'));
    }

    public function create()
    {
        $categories = Category::all();
        $statuses   = ['pending', 'in_progress', 'completed', 'cancelled'];
        $priorities = ['low', 'medium', 'high', 'critical'];

        return view('tasks.create', compact('categories', 'statuses', 'priorities'));
    }

    public function store(StoreTaskRequest $request)
    {
        try {
            $this->taskService->createTask($request->validated());
            return redirect()->route('tasks.index')
                             ->with('success', 'Task created successfully!');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['due_date' => $e->getMessage()])->withInput();
        }
    }

    public function show(Task $task)
    {
        $task->load('category');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $categories = Category::all();
        $statuses   = ['pending', 'in_progress', 'completed', 'cancelled'];
        $priorities = ['low', 'medium', 'high', 'critical'];

        return view('tasks.edit', compact('task', 'categories', 'statuses', 'priorities'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->taskService->updateTask($task, $request->validated());
        return redirect()->route('tasks.index')
                         ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        try {
            $this->taskService->deleteTask($task);
            return redirect()->route('tasks.index')
                             ->with('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}