<?php

namespace Database\Factories;

use App\EnumsTasksStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Task;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Task::class;
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'description' => Str::random(50),
            'status' => EnumsTasksStatus::TODO->value,
            'completionDate'=>fake()->date(),
            'user_id' => User::factory(),
        ];
    }
}
