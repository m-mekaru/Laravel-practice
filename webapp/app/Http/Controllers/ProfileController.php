<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面表示
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * プロフィール更新処理
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'profile_image' => ['nullable', 'image', 'max:2048'], // 2MBまで
        ]);

        // 画像アップロード
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image_path = $path;
        }

        // 情報更新
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // メールアドレス変更なら認証リセットなどの処理が必要ならここに書く

        $user->save();

        return Redirect::route('users.index')->with('success', 'プロフィールを更新しました。');
    }

    /**
     * ユーザー削除処理
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
