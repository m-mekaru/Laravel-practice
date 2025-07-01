<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('nav_title', 'タスク管理')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white p-4">
        <h1 class="text-xl">@yield('nav_title', 'タスク管理')</h1>
    </header>
    
    <main class="py-6">
        @yield('content')
    </main>
</body>
</html>
