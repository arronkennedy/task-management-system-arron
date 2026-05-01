<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    private TaskService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TaskService();
    }

    // ── createTask ──────────────────────────────────────────────

    /** @test */
    public function it_creates_a_task_with_valid_data(): void
    {
        $task = $this->service->createTask([
            'title'    => 'Test Task',
            'status'   => 'pending',
            'priority' => 'medium',
        ]);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    /** @test */
    public function it_throws_exception_for_past_due_date(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->service->createTask([
            'title'    => 'Old Task',
            'status'   => 'pending',
            'priority' => 'low',
            'due_date' => '2000-01-01',
        ]);
    }

    /** @test */
    public function it_creates_task_with_future_due_date(): void
    {
        $task = $this->service->createTask([
            'title'    => 'Future Task',
            'status'   => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDays(5)->toDateString(),
        ]);

        $this->assertNotNull($task->due_date);
    }

    // ── updateTask ──────────────────────────────────────────────

    /** @test */
    public function it_updates_task_status(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $updated = $this->service->updateTask($task, [
            'title'    => $task->title,
            'status'   => 'in_progress',
            'priority' => $task->priority,
        ]);

        $this->assertEquals('in_progress', $updated->status);
    }

    /** @test */
    public function it_sets_completed_at_when_marking_completed(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $updated = $this->service->updateTask($task, [
            'title'    => $task->title,
            'status'   => 'completed',
            'priority' => $task->priority,
        ]);

        $this->assertNotNull($updated->completed_at);
    }

    /** @test */
    public function it_clears_completed_at_when_reopening_task(): void
    {
        $task = Task::factory()->create([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);

        $updated = $this->service->updateTask($task, [
            'title'    => $task->title,
            'status'   => 'pending',
            'priority' => $task->priority,
        ]);

        $this->assertNull($updated->completed_at);
    }

    // ── deleteTask ──────────────────────────────────────────────

    /** @test */
    public function it_deletes_a_non_completed_task(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $result = $this->service->deleteTask($task);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_throws_exception_when_deleting_completed_task(): void
    {
        $task = Task::factory()->create(['status' => 'completed']);

        $this->expectException(\Exception::class);
        $this->service->deleteTask($task);
    }

    // ── getStatistics ──────────────────────────────────────────

    /** @test */
    public function it_returns_correct_statistics(): void
    {
        Task::factory()->create(['status' => 'pending']);
        Task::factory()->create(['status' => 'in_progress']);
        Task::factory()->create(['status' => 'completed', 'completed_at' => now()]);

        $stats = $this->service->getStatistics();

        $this->assertEquals(3, $stats['total']);
        $this->assertEquals(1, $stats['pending']);
        $this->assertEquals(1, $stats['in_progress']);
        $this->assertEquals(1, $stats['completed']);
    }

    /** @test */
    public function it_returns_zero_completion_rate_when_no_tasks(): void
    {
        $rate = $this->service->getCompletionRate();
        $this->assertEquals(0.0, $rate);
    }

    /** @test */
    public function it_calculates_completion_rate_correctly(): void
    {
        Task::factory()->count(3)->create(['status' => 'completed', 'completed_at' => now()]);
        Task::factory()->create(['status' => 'pending']);

        $rate = $this->service->getCompletionRate();
        $this->assertEquals(75.0, $rate);
    }

    /** @test */
    public function it_counts_overdue_tasks_in_statistics(): void
    {
        Task::factory()->create([
            'status'   => 'pending',
            'due_date' => now()->subDays(3)->toDateString(),
        ]);

        $stats = $this->service->getStatistics();
        $this->assertEquals(1, $stats['overdue']);
    }

    // ── getFilteredTasks ───────────────────────────────────────

    /** @test */
    public function it_filters_tasks_by_status(): void
    {
        Task::factory()->create(['status' => 'pending']);
        Task::factory()->create(['status' => 'completed', 'completed_at' => now()]);

        $result = $this->service->getFilteredTasks(['status' => 'pending']);
        $this->assertEquals(1, $result->total());
    }

    /** @test */
    public function it_filters_tasks_by_priority(): void
    {
        Task::factory()->create(['priority' => 'critical']);
        Task::factory()->create(['priority' => 'low']);

        $result = $this->service->getFilteredTasks(['priority' => 'critical']);
        $this->assertEquals(1, $result->total());
    }

    /** @test */
    public function it_filters_tasks_by_search_keyword(): void
    {
        Task::factory()->create(['title' => 'Write unit tests']);
        Task::factory()->create(['title' => 'Deploy application']);

        $result = $this->service->getFilteredTasks(['search' => 'unit']);
        $this->assertEquals(1, $result->total());
    }
}