<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskFilterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TaskFilterRequest $request)
    {

       // dd($request->all());

        $query = Task::query()
            ->where('user_id', auth()->id());

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('dateFrom')) {
            $query->whereDate('completionDate', '>=', $request->dateFrom);
        }

        if ($request->filled('dateTo')) {
            $query->whereDate('completionDate', '<=', $request->dateTo);
        }

        $query->orderBy('completionDate', 'desc');

       $tasks = $query->latest()->simplepaginate($request->perPage ?? 10)->withQueryString();
        return view('admin.task.index', compact('tasks'));
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
        Task::create([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'status' => $request->status,
            'completionDate' => $request->completionDate,
        ]);

        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
        dd('shoe');
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
    public function update(Request $request, Task $task)
    {
        $task->update([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'status' => $request->status,
            'completionDate' => $request->completionDate,
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
