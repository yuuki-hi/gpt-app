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
        @foreach($places as $place)
        <h2><a href = "place/{{ $place->id }}">{{ $place->place }}</a></h2>
        
        @endforeach
    </div>
    <a href="/place/create">新規登録</a>
</body>

</html>