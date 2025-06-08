<?php

namespace Tests\Feature;

use App\EnumsTasksStatus;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_UserCanUpdateOwnTask()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->patch("/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'status'=>EnumsTasksStatus::TODO->value,
            'completionDate' => now()->addDays(3)->toDateString(),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_UserCannotUpdateOtherUsersTask()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($otherUser);

        $response = $this->patch("/tasks/{$task->id}", [
            'title' => 'Hacked Title',
            'description' => 'Hacked Desc',
            'status'=>EnumsTasksStatus::TODO->value,
            'completionDate' => now()->addDays(3)->toDateString(),
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'title' => 'Hacked Title',
        ]);
    }

    public function test_UserCanDeleteOwnTask()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect();

        $this->assertSoftDeleted('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_UserCannotDeleteOtherUsersTask()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($otherUser);

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
        ]);
    }
}
