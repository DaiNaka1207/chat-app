<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Chat;
use Illuminate\Support\Facades\Cache;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        // ユーザー識別子をキャッシュに登録（なければランダムに生成）
        Cache::add('user_identifier', Str::random(20));
        
        // ユーザー名をキャッシュに登録（デフォルト値：Guest）
        Cache::add('user_name', 'Guest');

        // データーベースの件数を取得
        $length = Chat::all()->count();

        // 画面に表示する件数を代入
        $display = 20;

        // 最新のチャットを画面に表示する分だけ取得して変数に代入
        $chats = Chat::offset($length-$display)->limit($display)->get();

        // チャットデータをビューに渡して表示
        return view('chat.index',compact('chats'));
    }

    public function store(Request $request)
    {
        // フォームに入力されたユーザー名をキャッシュに登録
        Cache::put('user_name', $request->user_name);

        // フォームに入力されたチャットデータをデータベースに登録
        $chat = new Chat;
        $form = $request->all();
        $chat->fill($form)->save();

        // 最初の画面にリダイレクト
        return redirect(route('chat.index'));
    }
}
