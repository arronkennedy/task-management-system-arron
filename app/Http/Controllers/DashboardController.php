<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use App\Models\Category;

class DashboardController extends Controller
{
    public function __construct(private TaskService $taskService) {}

    public function index()
    {
        $stats          = $this->taskService->getStatistics();
        $completionRate = $this->taskService->getCompletionRate();
        $categories     = Category::withCount('tasks')->get();

        return view('dashboard', compact('stats', 'completionRate', 'categories'));
    }
}