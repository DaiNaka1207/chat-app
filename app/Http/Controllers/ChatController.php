<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        // Cookieを変数に読み込み
        $user = [
            'name' => $request->cookie('chat-app_name'),
            'identifier' => $request->cookie('chat-app_identifier'),
        ];

        // Cookieが存在しなければデフォルト値を設定
        if ($user['name'] === null) {
            
            $user = [
                'name' => 'Guest',
                'identifier' => Str::random(20),
            ];

            Cookie::queue('chat-app_name', $user['name']);
            Cookie::queue('chat-app_identifier', $user['identifier']);
        }

        // データーベースの件数を取得
        $length = Chat::all()->count();

        // 画面に表示する件数を代入
        $display = 20;

        // 最新のチャットを画面に表示する分だけ取得して変数に代入
        $chats = Chat::offset($length-$display)->limit($display)->get();

        // チャットデータをビューに渡して表示
        return view('chat.index', compact('chats', 'user'));
    }

    public function store(Request $request)
    {
        // フォームに入力されたユーザー名をCookieに登録
        Cookie::queue('chat-app_name', $request->user_name);

        // フォームに入力されたチャットデータをデータベースに登録
        $chat = new Chat;
        $form = $request->all();
        $chat->fill($form)->save();

        // 最初の画面にリダイレクト
        return redirect(route('chat.index'));
    }
}
