<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function view(User $user , $task)
    {
        return $user->id === $task->user_id;
    }
//
//    public function create(User $user)
//    {
//        return $user->id === in_array($user->id , [1,2,3]);
//    }

    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }

    public function delete(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }


}
