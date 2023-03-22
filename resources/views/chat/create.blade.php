<html>

<head>
    <meta charset='utf-8' />
</head>

<body>
    {{-- フォーム --}}
    <form method="POST">
        @csrf
        <textarea rows="10" cols="50" name="sentence">{{ isset($sentence) ? $sentence : '' }}</textarea>
        <button type="submit">ChatGPT</button>
    </form>

    {{-- 結果 --}}
    歴史に関する観光地
    <br>
    {{ isset($response_history) ? $response_history : '' }}
    <br>
    自然に関する観光地
    <br>
    {{ isset($response_nature) ? $response_nature : '' }}
    <br>
    食
    <br>
    {{ isset($response_food) ? $response_food : '' }}
</body>

</html>