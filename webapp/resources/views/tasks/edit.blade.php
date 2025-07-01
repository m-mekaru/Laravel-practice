<form method="POST" action="{{ route('tasks.update', $task->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="title" class="block font-medium text-gray-700">タイトル</label>
        <input id="title" type="text" name="title" value="{{ old('title', $task->title) }}" required
            class="mt-1 block w-full border rounded px-3 py-2" />
    </div>

    <div class="mb-4">
        <label for="assigned_user_id" class="block font-medium text-gray-700">担当者</label>
        <select id="assigned_user_id" name="assigned_user_id" required
            class="mt-1 block w-full border rounded px-3 py-2">
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @if(old('assigned_user_id', $task->assigned_user_id) == $user->id) selected @endif>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- ステータス -->
    <div class="mb-4">
        <label for="task_status" class="block font-medium text-gray-700">ステータス</label>
        <select id="task_status" name="task_status" required
            class="mt-1 block w-full border rounded px-3 py-2">
            @foreach (['未着手', '着手中', '保留', '完了'] as $status)
                <option value="{{ $status }}" @if(old('task_status', $task->task_status) === $status) selected @endif>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- 説明 -->
    <div class="mb-4">
        <label for="description" class="block font-medium text-gray-700">説明</label>
        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border rounded px-3 py-2">{{ old('description', $task->description) }}</textarea>
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">更新</button>
</form>
