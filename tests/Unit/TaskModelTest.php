<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_detects_completed_status(): void
    {
        $task = Task::factory()->make(['status' => 'completed']);
        $this->assertTrue($task->isCompleted());
    }

    /** @test */
    public function it_detects_cancelled_status(): void
    {
        $task = Task::factory()->make(['status' => 'cancelled']);
        $this->assertTrue($task->isCancelled());
    }

    /** @test */
    public function overdue_returns_false_for_completed_task(): void
    {
        $task = Task::factory()->make([
            'status'   => 'completed',
            'due_date' => now()->subDays(5),
        ]);
        $this->assertFalse($task->isOverdue());
    }

    /** @test */
    public function overdue_returns_true_for_past_due_pending_task(): void
    {
        $task = Task::factory()->create([
            'status'   => 'pending',
            'due_date' => now()->subDays(2)->toDateString(),
        ]);
        $this->assertTrue($task->isOverdue());
    }

    /** @test */
    public function it_marks_task_as_completed(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);
        $task->markAsCompleted();

        $this->assertEquals('completed', $task->fresh()->status);
        $this->assertNotNull($task->fresh()->completed_at);
    }

    /** @test */
    public function priority_level_returns_correct_values(): void
    {
        $this->assertEquals(1, Task::factory()->make(['priority' => 'low'])->priority_level);
        $this->assertEquals(2, Task::factory()->make(['priority' => 'medium'])->priority_level);
        $this->assertEquals(3, Task::factory()->make(['priority' => 'high'])->priority_level);
        $this->assertEquals(4, Task::factory()->make(['priority' => 'critical'])->priority_level);
    }
}