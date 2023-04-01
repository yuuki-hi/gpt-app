<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>観光地情報</title>
</head>

<body>
    {{-- フォーム --}}
    <form method="POST">
        @csrf
        <textarea rows="5" cols="50" name="sentence">{{ isset($sentence) ? $sentence : '' }}</textarea>
        <button type="submit">ChatGPT</button>
    </form>
</body>

</html>