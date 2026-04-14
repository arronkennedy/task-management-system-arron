<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'in_progress', 'completed', 'cancelled']);

        return [
            'title'        => $this->faker->sentence(4),
            'description'  => $this->faker->paragraph(),
            'status'       => $status,
            'priority'     => $this->faker->randomElement(['low', 'medium', 'high', 'critical']),
            'category_id'  => Category::factory(),
            'due_date'     => $this->faker->optional()->dateTimeBetween('now', '+30 days'),
            'completed_at' => $status === 'completed' ? now() : null,
        ];
    }
}