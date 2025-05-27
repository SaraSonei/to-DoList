<?php

namespace App\Http\Controllers;

use App\EnumPerPage;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskFilterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\EnumsTasksStatus;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TaskFilterRequest $request)
    {
        $data = $request->validated();
        $dateFrom = $request->filled('dateFrom') ? $data['dateFrom'] : now()->toDateString();
        $dateTo = $request->filled('dateTo') ? $data['dateTo'] : now()->toDateString();
        $perPage = $request->filled('perPage') ? $data['perPage'] : EnumPerPage::TEN->value;
        $query = Task::query()
            ->where('user_id', auth()->id());

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $data['title'] . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $data['status']);
        }

        $query->whereBetween('completionDate', [$dateFrom, $dateTo]);

        $query->orderBy('completionDate', 'desc');

       $tasks = $query->latest()->simplepaginate($perPage)->withQueryString();
        return view('admin.task.index', compact('tasks' ,'dateFrom', 'dateTo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $completionDate = $request->filled('completionDate') ? $data['completionDate'] : now()->toDateString();
        $status = $request->filled('status') ? $data['status'] : EnumsTasksStatus::TODO;
        Task::create([
            'title' => $data['title'],
            'user_id' => Auth::user()->id,
            'description' => $data['description'],
            'status' => $status,
            'completionDate' => $completionDate,
        ]);

        return redirect(route('tasks.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        Gate::authorize('update', $task);
        return view('admin.task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $completionDate = $request->filled('completionDate') ? $data['completionDate'] : now()->toDateString();
        $task->update([
            'title' => $data['title'],
            'user_id' => Auth::user()->id,
            'description' => $data['description'],
            'status' => $data['status'],
            'completionDate' => $completionDate,
        ]);


        return redirect('/admin/tasks');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('update', $task);
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
