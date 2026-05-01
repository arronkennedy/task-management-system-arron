<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_categories_list(): void
    {
        Category::factory()->count(3)->create();

        $this->get(route('categories.index'))
             ->assertOk()
             ->assertViewIs('categories.index');
    }

    /** @test */
    public function it_creates_a_category(): void
    {
        $this->post(route('categories.store'), [
            'name'  => 'Personal',
            'color' => '#ff5733',
        ])->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', ['name' => 'Personal']);
    }

    /** @test */
    public function it_validates_unique_category_name(): void
    {
        Category::factory()->create(['name' => 'Work']);

        $this->post(route('categories.store'), [
            'name'  => 'Work',
            'color' => '#000000',
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function it_deletes_empty_category(): void
    {
        $category = Category::factory()->create();

        $this->delete(route('categories.destroy', $category))
             ->assertRedirect(route('categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function it_cannot_delete_category_with_tasks(): void
    {
        $category = Category::factory()->create();
        Task::factory()->create(['category_id' => $category->id]);

        $this->delete(route('categories.destroy', $category))
             ->assertRedirect();

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}