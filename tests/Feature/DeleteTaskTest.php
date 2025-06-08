<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
Use App\EnumsTasksStatus;


class DeleteTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_TaskCanBeDeletedByAuthenticatedUser()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $task = Task::create([
            'title' => 'Task to be deleted',
            'description' => 'This will be deleted',
            'status'=>EnumsTasksStatus::INPROGRESS->value,
            'completionDate' => now()->addDays(3),
            'user_id' => $user->id,
        ]);

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect();

        $this->assertSoftDeleted('tasks', [
            'id' => $task->id,
        ]);
    }
}
