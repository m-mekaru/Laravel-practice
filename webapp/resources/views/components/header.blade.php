<nav class="bg-gray-800 p-4 text-white flex justify-between items-center max-w-2xl mx-auto space-y-6">
  <!-- 左：ロゴやタイトル -->
  <div class="text-lg font-bold">
  @yield('nav_title', 'タスク管理システム')
</div>

  <!-- 中央：ナビアイコン -->
  <div class="space-x-2">
    <a href="{{ route('tasks.index') }}" class="bg-green-700 px-3 py-1 rounded text-white text-sm">タスク一覧</a>
    <a href="{{ route('tasks.create') }}" class="bg-green-700 px-3 py-1 rounded text-white text-sm">タスク新規登録</a>
    <a href="{{ route('profile.edit') }}" class="bg-green-700 px-3 py-1 rounded text-white text-sm">ユーザー情報変更</a>
    <form method="POST" action="{{ route('logout') }}" class="inline">
  </div>

  <!-- 右：ユーザー名とログアウト -->
  <div class="flex items-center space-x-4">
    <span>{{ Auth::user()->name }}</span>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="bg-green-700 px-3 py-1 rounded text-white text-sm">ログアウト</button>
    </form>
  </div>
</nav>
