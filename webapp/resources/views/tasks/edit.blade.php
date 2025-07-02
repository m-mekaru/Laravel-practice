@extends('layouts.app')
@section('nav_title', 'タスク編集')

@section('content')
    <div class="container max-w-2xl mx-auto p-4 bg-white rounded shadow">
        {{-- 戻るボタン --}}
        <button type="button" onclick="history.back()" class="mb-4 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
            ← 戻る
        </button>

        {{-- エラーメッセージ --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- タスク編集フォーム --}}
        <form method="POST" action="{{ route('tasks.update', $task->id) }}">
            @csrf
            @method('PUT')

            {{-- タイトル --}}
            <div class="mb-4">
                <label for="title" class="block font-semibold text-gray-700">タスク名 <span class="text-red-500">*</span></label>
                <input id="title" type="text" name="title" value="{{ old('title', $task->title) }}" 
                       class="mt-1 block w-full border px-3 py-2 rounded" required>
            </div>

            {{-- 担当者 --}}
            <div class="mb-4">
                <label for="assigned_user_id" class="block font-semibold text-gray-700">担当者 <span class="text-red-500">*</span></label>
                <select id="assigned_user_id" name="assigned_user_id" required 
                        class="mt-1 block w-full border px-3 py-2 rounded">
                    <option value="">選択してください</option>
                    <option value="me" {{ old('assigned_user_id', $task->assigned_user_id) == auth()->id() ? 'selected' : '' }}>自分</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_user_id', $task->assigned_user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ステータス --}}
            <div class="mb-4">
                <label for="task_status" class="block font-semibold text-gray-700">ステータス <span class="text-red-500">*</span></label>
                <select id="task_status" name="task_status" required 
                        class="mt-1 block w-full border px-3 py-2 rounded">
                    <option value="">選択してください</option>
                    @foreach(['未着手', '着手中', '保留', '完了'] as $status)
                        <option value="{{ $status }}" {{ old('task_status', $task->task_status) === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 備考 --}}
            <div class="mb-6">
                <label for="description" class="block font-semibold text-gray-700">備考</label>
                <textarea id="description" name="description" rows="4" 
                          class="mt-1 block w-full border px-3 py-2 rounded">{{ old('description', $task->description) }}</textarea>
            </div>

            {{-- 送信ボタン --}}
            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    更新
                </button>
            </div>
        </form>
    </div>
@endsection
