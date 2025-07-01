@section('nav_title', 'タスク新規作成')

<x-app-layout>
    <x-slot name="header">
</x-slot>


    <div class=" max-w-2xl mx-auto space-y-6">

        <div class="container max-w-2xl mx-auto p-4 bg-white rounded shadow">
        {{-- 戻るボタン --}}
        <button type="button" onclick="history.back()" class="mb-4 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
            ← 戻る
        </button>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label class="block font-semibold">タスク名 <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border px-3 py-2 rounded" form="taskForm">
        </div>

        <div>
            <label class="block font-semibold">担当者 <span class="text-red-500">*</span></label>
            <select name="assigned_user_id" class="w-full border px-3 py-2 rounded" form="taskForm">
                <option value="">選択してください</option>
                <option value="me" {{ old('assigned_user_id') === 'me' ? 'selected' : '' }}>自分</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('assigned_user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">ステータス <span class="text-red-500">*</span></label>
            <select name="task_status" class="w-full border px-3 py-2 rounded" form="taskForm">
                <option value="">選択してください</option>
                @foreach(['未着手', '着手中', '保留', '完了'] as $status)
                    <option value="{{ $status }}" {{ old('task_status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">備考</label>
            <textarea name="description" rows="4" class="w-full border px-3 py-2 rounded" form="taskForm">{{ old('description') }}</textarea>
        </div>

        <form id="taskForm" method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">登録</button>
        </form>
    </div>
</x-app-layout>
