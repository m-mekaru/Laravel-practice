<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index(Request $request)
{
    $query = Task::with('user');

    if ($keyword = $request->input('keyword')) {
        $query->where('title', 'like', "%{$keyword}%");
    }

    if ($userId = $request->input('user_id')) {
        if ($userId === 'me') {
            $query->where('assigned_user_id', auth()->id());
        } else {
            $query->where('assigned_user_id', $userId);
        }
    }

    if ($status = $request->input('status')) {
        $query->where('task_status', $status);
    }

    $sortBy = $request->input('sort_by', 'id');
    $sortOrder = $request->input('sort_order', 'asc');

    $allowedSorts = ['id', 'title', 'assigned_user_id', 'task_status'];
    if (!in_array($sortBy, $allowedSorts)) {
        $sortBy = 'id';
    }
    if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
        $sortOrder = 'asc';
    }

    $query->orderBy($sortBy, $sortOrder);

    $tasks = $query->paginate(10)->withQueryString();

    $users = User::whereNotNull('name')->get();

    return view('tasks.index', compact('tasks', 'users'));
}

    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    public function store(TaskRequest $request)
    {
        Task::createFromRequest($request->validated());

        return redirect()->route('tasks.index')->with('success', 'タスクを登録しました！');
    }

    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->updateFromRequest($request->validated());

        return redirect()->route('tasks.index')->with('success', 'タスクを更新しました！');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました！');
    }
}
