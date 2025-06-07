<?php

namespace App\Http\Controllers;

use App\EnumPerPage;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskFilterRequest;
use Illuminate\Support\Facades\Auth;
use App\EnumsTasksStatus;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TaskFilterRequest $request)
    {
        $data = $request->validated();

        $toDay =  now()->toDateString();
        $tomorrow =  now()->add('1 day')->toDateString();

        $dateFrom = $request->filled('dateFrom') ? $this->checkCompletionDate($data['dateFrom'] ): $toDay;
        $dateTo = $request->filled('dateTo') ? $this->checkCompletionDate($data['dateTo']) : $tomorrow;

        $perPage = $request->filled('perPage') ? $data['perPage'] : EnumPerPage::TEN->value;

        $tasks = Task::query()
            ->ownedBy(auth()->id())
            ->filterTitle($data['title'] ?? null)
            ->filterStatus($data['status'] ?? null)
            ->completionBetween($dateFrom, $dateTo)
            ->orderByDesc('completionDate')
            ->latest()
            ->simplePaginate($perPage)
            ->withQueryString();

        $dateFrom = formatDateForDisplay($dateFrom);
        $dateTo = formatDateForDisplay($dateTo);

       return view('tasks.index', compact('tasks' ,'dateFrom', 'dateTo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $completionDate = $this->checkCompletionDate($data['completionDate'] ?? null);
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
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);
        $data = $request->validated();
        $completionDate = $this->checkCompletionDate($data['completionDate'] ?? null);
        $task->update([
            'title' => $data['title'],
            'user_id' => Auth::user()->id,
            'description' => $data['description'],
            'status' => $data['status'],
            'completionDate' => $completionDate,
        ]);


        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();
        return redirect(route('tasks.index'));
    }

    public function checkCompletionDate(?string $inputDate = null): string
    {
        if (isJalali()) {
            $persianDate = $inputDate ?? Jalalian::now()->format('Y-m-d');
            return Jalalian::fromFormat('Y-m-d', $persianDate)
                ->toCarbon()
                ->toDateString();
        }

        return $inputDate ?? now()->toDateString();
    }

}
