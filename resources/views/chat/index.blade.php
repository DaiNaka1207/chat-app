<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>

        <style>
            /* 他人のコメントの吹き出し */
            .other::before {
                content: "";
                position: absolute;
                top: 90%;
                left: -15px;
                margin-top: -30px;
                border: 5px solid transparent;
                border-right: 15px solid #c7deff;
            }

            /* 自身のコメントの吹き出し */
            .self::after {
                content: "";
                position: absolute;
                top: 50%;
                left: 100%;
                margin-top: -15px;
                border: 3px solid transparent;
                border-left: 9px solid #c7deff;
            }
        </style>
    </head>
    <body class="w-4/5 md:w-3/5 lg:w-2/5 m-auto">
        {{-- アプリのタイトル（.envに設定されているアプリ名を取得） --}}
        <h1 class="my-4 text-3xl font-bold">{{env('APP_NAME')}}</h1>
            <ul>
                {{-- チャットデータを繰り返し表示 --}}
                @foreach ($chats as $chat)
                    <p class="text-xs @if($chat->user_identifier == session('user_identifier')) text-right @endif">{{$chat->created_at}} ＠{{$chat->user_name}}</p>
                    <li class="w-max mb-3 p-2 rounded-lg bg-blue-200 relative @if($chat->user_identifier == session('user_identifier')) self ml-auto @else other @endif">
                        {{$chat->message}}
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- 入力フォーム --}}
        <form class="my-4 py-2 px-4 rounded-lg bg-gray-300 text-sm flex flex-col md:flex-row flex-grow" action="/chat" method="POST">
            @csrf
            {{-- ユーザー識別子を隠しパラメータで保有 --}}
            <input type="hidden" name="user_identifier" value={{session('user_identifier')}}>
            {{-- ユーザー名フォーム --}}
            <input class="py-1 px-2 rounded text-center flex-initial" type="text" name="user_name" placeholder="UserName" maxlength="20" value="{{session('user_name')}}" required>
            {{-- メッセージフォーム --}}
            <input class="mt-2 md:mt-0 md:ml-2 py-1 px-2 rounded flex-auto" type="text" name="message" placeholder="Input message." maxlength="200" autofocus required>
            {{-- 送信ボタン --}}
            <button class="mt-2 md:mt-0 md:ml-2 py-1 px-2 rounded text-center bg-gray-500 text-white" type="submit">送信</button>
        </form>
    </body>
</html>
