<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\EnumsTasksStatus;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_taskCreatedByAuthenticatedUser(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'status' => EnumsTasksStatus::TODO->value,
            'completionDate' => now()->addDays(2)->toDateString(),
        ];

        $response = $this->post('/tasks', $taskData);

        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'status' => EnumsTasksStatus::TODO->value,
            'completionDate' => now()->addDays(2)->toDateString(),
            'user_id' => $user->id,
        ]);
    }
}
