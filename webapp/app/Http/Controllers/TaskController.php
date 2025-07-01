<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; 
use App\Models\User;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->paginate(10);
        $users = User::whereNotNull('name')->get();

    return view('tasks.index', compact('tasks', 'users'));
    }

    public function create()
    {
         $users = User::all();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'assigned_user_id' => 'required|exists:users,id',
            'task_status' => 'required|in:未着手,着手中,保留,完了',
            'description' => 'nullable|string',
        ]);

        Task::create([
            'title' => $request->title,
            'assigned_user_id' => $request->assigned_user_id === 'me' ? auth()->id() : $request->assigned_user_id,
            'task_status' => $request->task_status,
            'description' => $request->description,
        ]);

        return redirect()->route('tasks.index')->with('success', 'タスクを登録しました！');
    }
    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'assigned_user_id' => 'required|exists:users,id',
            'task_status' => 'required|in:未着手,着手中,保留,完了',
            'description' => 'nullable|string',
    ]);

    $task->update([
        'title' => $request->title,
        'assigned_user_id' => $request->assigned_user_id === 'me' ? auth()->id() : $request->assigned_user_id,
        'task_status' => $request->task_status,
        'description' => $request->description,
    ]);

    return redirect()->route('tasks.index')->with('success', 'タスクを更新しました！');
}


    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました！');
}


}
