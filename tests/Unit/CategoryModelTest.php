<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_correct_task_count(): void
    {
        $category = Category::factory()->create();
        Task::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertEquals(3, $category->task_count);
    }

    /** @test */
    public function it_returns_zero_task_count_when_no_tasks(): void
    {
        $category = Category::factory()->create();

        $this->assertEquals(0, $category->task_count);
    }
}