<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面表示
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * プロフィール更新処理
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            // バリデーション済みデータを取得
            $data = $request->validated();

            // 画像アップロード
            if ($request->hasFile('profile_image')) {
                $path = $request->file('profile_image')->store('profile_images', 'public');
                $data['profile_image_path'] = $path;
            }

            // モデルのメソッドに更新処理を任せる
            $user->updateProfile($data);
        });

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

        DB::transaction(function () use ($user, $request) {
            Auth::logout();
            $user->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        });

        return Redirect::to('/');
    }
}
