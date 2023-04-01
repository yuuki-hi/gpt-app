<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>観光地情報</title>
</head>

<body>
    <h1>観光地情報</h1>

    <div>
        @php
        $history = json_decode($place->info->history);
        $nature = json_decode($place->info->nature);
        $food = json_decode($place->info->food);
        @endphp

        <h2>{{ $place->place }}</h2>
        <h3>歴史</h3>
        <ul>
            @foreach($history as $data)
            <li>{{ $data->place }} - {{ $data->info }}</li>
            @endforeach
        </ul>
        <h3>自然</h3>
        <ul>
            @foreach($nature as $data)
            <li>{{ $data->place }} - {{ $data->info }}</li>
            @endforeach
        </ul>
        <h3>食べ物</h3>
        <ul>
            @foreach($food as $data)
            <li>{{ $data->place }} - {{ $data->info }}</li>
            @endforeach
        </ul>
    </div>
    <a href="/place">編集</a>
    <a href="/place">削除</a>
    <a href="/place">back</a>
</body>

</html>