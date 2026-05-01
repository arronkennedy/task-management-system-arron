<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_task_list(): void
    {
        Task::factory()->count(3)->create();

        $this->get(route('tasks.index'))
             ->assertOk()
             ->assertViewIs('tasks.index');
    }

    /** @test */
    public function it_creates_a_task_via_form(): void
    {
        $this->post(route('tasks.store'), [
            'title'    => 'My Integration Task',
            'status'   => 'pending',
            'priority' => 'high',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', ['title' => 'My Integration Task']);
    }

    /** @test */
    public function it_validates_required_title(): void
    {
        $this->post(route('tasks.store'), [
            'title'    => '',
            'status'   => 'pending',
            'priority' => 'medium',
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    public function it_updates_a_task(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $this->put(route('tasks.update', $task), [
            'title'    => 'Updated Title',
            'status'   => 'in_progress',
            'priority' => 'high',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id'     => $task->id,
            'title'  => 'Updated Title',
            'status' => 'in_progress',
        ]);
    }

    /** @test */
    public function it_deletes_a_pending_task(): void
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $this->delete(route('tasks.destroy', $task))
             ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_cannot_delete_a_completed_task(): void
    {
        $task = Task::factory()->create([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);

        $this->delete(route('tasks.destroy', $task))
             ->assertRedirect();

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_shows_task_detail(): void
    {
        $task = Task::factory()->create();

        $this->get(route('tasks.show', $task))
             ->assertOk()
             ->assertViewIs('tasks.show')
             ->assertSee($task->title);
    }

    /** @test */
    public function it_filters_tasks_by_status(): void
    {
        Task::factory()->create(['title' => 'Pending Task',   'status' => 'pending']);
        Task::factory()->create(['title' => 'Completed Task', 'status' => 'completed', 'completed_at' => now()]);

        $this->get(route('tasks.index', ['status' => 'pending']))
             ->assertOk()
             ->assertSee('Pending Task')
             ->assertDontSee('Completed Task');
    }
}