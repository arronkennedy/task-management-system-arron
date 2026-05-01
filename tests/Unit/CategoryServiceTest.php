<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Task;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private CategoryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CategoryService();
    }

    /** @test */
    public function it_creates_category_with_valid_color(): void
    {
        $category = $this->service->createCategory([
            'name'  => 'Work',
            'color' => '#ff5733',
        ]);
        $this->assertDatabaseHas('categories', ['name' => 'Work']);
    }

    /** @test */
    public function it_throws_on_invalid_color_format(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->createCategory(['name' => 'Bad', 'color' => 'red']);
    }

    /** @test */
    public function it_throws_when_deleting_category_with_tasks(): void
    {
        $category = Category::factory()->create();
        Task::factory()->create(['category_id' => $category->id]);

        $this->expectException(\Exception::class);
        $this->service->deleteCategory($category);
    }

    /** @test */
    public function it_deletes_empty_category(): void
    {
        $category = Category::factory()->create();
        $result   = $this->service->deleteCategory($category);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}