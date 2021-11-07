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
    </head>
    <body class="w-4/5 md:w-3/5 lg:w-2/5 m-auto">
        <h1 class="my-4 text-3xl font-bold">{{env('APP_NAME')}}</h1>
        <div class="my-4 p-4 rounded-lg bg-blue-200">
            <ul>
                @foreach ($chats as $chat)
                    <li class="truncate">{{$chat->getData()}}</li>
                @endforeach
            </ul>
        </div>
        <form class="my-4 py-2 px-4 rounded-lg bg-gray-300 text-sm flex flex-col md:flex-row flex-grow" action="/chat" method="POST">
            @csrf
            <input type="hidden" name="user_identifier" value="test">
            <input class="py-1 px-2 rounded text-center flex-initial" type="text" name="user_name" placeholder="UserName" maxlength="20">
            <input class="mt-2 md:mt-0 md:ml-2 py-1 px-2 rounded flex-auto" type="text" name="message" placeholder="Input message." maxlength="200">
            <button class="mt-2 md:mt-0 md:ml-2 py-1 px-2 rounded text-center bg-gray-500 text-white" type="submit">Send</button>
        </form>
    </body>
</html>
