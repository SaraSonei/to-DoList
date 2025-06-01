<?php

namespace App\Http\Controllers\Api;

use App\EnumPerPage;
use App\EnumsTasksStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\TasksResource;
use Illuminate\Http\Request;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Http\Requests\Api\TasksRequest;
use App\Http\Resources\storeTaskResource;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(TasksRequest $request)
    {
        $data = $request->validated();

        $toDay = time();
        $tomorrow =  strtotime('tomorrow');
        $perPage = $request->filled('perPage') ? $data['perPage'] : EnumPerPage::TEN->value;

        $date_From = $request->filled('dateFrom') ? $data['dateFrom'] : $toDay;
        $date_To = $request->filled('dateTo') ? $data['dateTo'] : $tomorrow;

        $dateFrom =  date('Y-m-d', $date_From);
        $dateTo =  date('Y-m-d', $date_To);

        $tasks = Task::query()
            ->ownedBy(auth()->user()->id)
            ->filterTitle($data['title'] ?? null)
            ->filterStatus($data['status'] ?? null)
            ->completionBetween($dateFrom, $dateTo)
            ->orderByDesc('completionDate')
            ->latest()
            ->offset(0)
            ->limit($perPage)
            ->get();


        return TasksResource::collection($tasks);
    }

    public function Store (StoreTaskRequest $request)
    {
        $data = $request->validated();

        $date  = $request->filled('completionDate') ? $data['completionDate'] : time();
        $completionDate =  date('Y-m-d', $date);

        $task = Task::Create(
            [
                'title' => $data['title'],
                'user_id' => auth()->user()->id,
                'description' => $data['description'],
                'status' => $data['status'],
                'completionDate' => $completionDate,
            ]
        );

        return new storeTaskResource($task);
    }
}
