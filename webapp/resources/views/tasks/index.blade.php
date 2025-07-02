@extends('layouts.app')
@section('nav_title', 'タスク一覧')

@section('content')
    <div class="container max-w-2xl mx-auto p-4 bg-white rounded shadow">
        {{-- 戻るボタン --}}
        <button type="button" onclick="history.back()" class="mb-4 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
            ← 戻る
        </button>

        <div class="p-6 bg-white rounded shadow mt-4">
            {{-- ここに元の中身をそのままコピー --}}
            <div class="max-w-2xl mx-auto space-y-6">
                <div class="flex items-center space-x-2">
                    <img src="{{ auth()->user()->profile_photo_url ?? asset('default-profile.png') }}" alt="ユーザーアイコン" class="w-12 h-12 rounded-full">
                    <div>
                        <p class="font-bold text-red-600">ログイン中ユーザー</p>
                        <p>{{ auth()->user()->name }}</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap items-center gap-3">
                    <!-- フリーワード検索 -->
                    <input type="text" name="keyword" placeholder="フリーワード検索" value="{{ request('keyword') }}" class="border rounded px-3 py-1 w-60 h-9">

                <!-- 担当者セレクト -->
                    <div class="relative w-40">
                       <select name="user_id" class="border rounded px-3 py-1 pr-8 appearance-none w-full h-9">
                            <option value="">担当者</option>
                            <option value="me" @selected(request('user_id') === 'me')>
                                {{ Auth::user()?->name ?? '自分' }}
                            </option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">▼</div>
                    </div>

                    <!-- ステータスセレクト -->
                    <div class="relative w-40">
                        <select name="status" class="border rounded px-3 py-1 pr-8 appearance-none w-full h-9">
                            <option value="">ステータス</option>
                            @foreach(['未着手', '着手中', '保留', '完了'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">▼</div>
                    </div>

                    <!-- 絞り込みボタン -->
                    <button type="submit" class="bg-green-700 text-white px-4 py-1 rounded">絞り込み</button>
                </form>
            </div>

            <table class="table-auto w-full border border-gray-300 text-center mt-6">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-2 py-1 cursor-pointer" wire:click="sort('id')">ID</th>
                        <th class="border border-gray-300 px-2 py-1 cursor-pointer" wire:click="sort('title')">タスク名</th>
                        <th class="border border-gray-300 px-2 py-1 cursor-pointer" wire:click="sort('user_id')">担当者</th>
                        <th class="border border-gray-300 px-2 py-1 cursor-pointer" wire:click="sort('task_status')">ステータス</th>
                        <th class="border border-gray-300 px-2 py-1">編集</th>
                        <th class="border border-gray-300 px-2 py-1">削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr @class(['bg-gray-100' => $loop->even])>
                            <td class="border border-gray-300 px-2 py-1">{{ $task->id }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $task->title }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $task->user->name }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $task->task_status }}</td>
                            <td class="border border-gray-300 px-2 py-1">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded">編集</a>
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" onsubmit="return confirm('削除します。よろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
@endsection
