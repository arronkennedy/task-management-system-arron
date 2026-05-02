<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_dashboard(): void
    {
        $this->get(route('dashboard'))
             ->assertOk()
             ->assertViewIs('dashboard');
    }

    /** @test */
    public function it_shows_correct_stats_on_dashboard(): void
    {
        Task::factory()->create(['status' => 'pending']);
        Task::factory()->create(['status' => 'completed', 'completed_at' => now()]);

        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('stats');
        $response->assertViewHas('completionRate');
        $response->assertViewHas('categories');
    }

    /** @test */
    public function it_shows_categories_on_dashboard(): void
    {
        Category::factory()->count(3)->create();

        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('categories', function ($categories) {
            return $categories->count() === 3;
        });
    }
}