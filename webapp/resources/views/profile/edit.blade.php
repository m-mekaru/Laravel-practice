@extends('layouts.app')
@section('nav_title', 'ユーザー情報変更')

@section('content')
    <div class="container max-w-2xl mx-auto p-4 bg-white rounded shadow">
        {{-- 戻るボタン --}}
        <button type="button" onclick="history.back()" class="mb-4 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
            ← 戻る
        </button>

        {{-- フォーム --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            @php
                $user = Auth::user();
                $profileImage = $user->profile_image_path ?? null;
            @endphp

            {{-- プロフィール画像表示 --}}
            <div class="mb-4">
                <label class="block mb-1 font-semibold">プロフィール画像</label>
                <img 
                    src="{{ $profileImage ? asset('storage/' . $profileImage) : asset('images/default_profile.png') }}" 
                    alt="プロフィール画像" 
                    class="w-24 h-24 rounded-full object-cover border border-gray-300"
                >
            </div>

            {{-- 画像アップロード --}}
            <div class="mb-4">
                <label for="profile_image" class="block font-semibold mb-1">画像を選択（任意）</label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*" class="block w-full border rounded p-2">
                @error('profile_image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ユーザー名 --}}
            <div class="mb-4">
                <label for="name" class="block font-semibold mb-1">ユーザー名 <span class="text-red-600">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="block w-full border rounded p-2">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="mb-4">
                <label for="email" class="block font-semibold mb-1">メールアドレス <span class="text-red-600">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="block w-full border rounded p-2">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 登録ボタン --}}
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    登録
                </button>
            </div>
        </form>
    </div>
@endsection