<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
Use App\EnumsTasksStatus;

class UpdateTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_updateTaskByAuthenticatedUser(): void
    {
        $user = user::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'status'=>EnumsTasksStatus::INPROGRESS->value,
            'completionDate' => now()->addDays(2)->toDateString(),

        ]);

        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'status' => EnumsTasksStatus::COMPLETED->value,
            'completionDate' => now()->addDays(5)->toDateString(),
        ];

        $response = $this->patch("/tasks/{$task->id}", $updatedData);
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'status' => EnumsTasksStatus::COMPLETED->value,
            'completionDate' => $updatedData['completionDate'],
        ]);


    }
}
