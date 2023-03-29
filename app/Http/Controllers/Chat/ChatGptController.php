<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatGptController extends Controller
{
    /**
     * chat
     *
     * @param  Request  $request
     */
    public function chat(Request $request)
    {
        // バリデーション
        $request->validate([
            'sentence' => 'required',
        ]);

        // 文章
        $sentence = $request->input('sentence');

        $sentence = "{$sentence}";

        // ChatGPT API処理
        $sentence_system = "次の例のように書いてください．例:\n【建築物の名前】\n紹介文．";

        $response_history = $this->chat_gpt("次の地名について，歴史的な建築物(神社や寺など)をいくつか紹介してください．絶対に次の例のように書いてください．例:\n【紹介する物の名前】\n紹介文．", $sentence);

        $response_nature = $this->chat_gpt("次の地名について，自然に関する観光地(温泉や湖，川，山，滝，森など)をいくつか紹介してください．絶対に次の例のように書いてください．例:\n【紹介する物の名前】\n紹介文．", $sentence);

        $response_food = $this->chat_gpt("次の地名について，おすすめグルメや食文化をいくつか紹介してください．絶対に次の例のように書いてください．例:\n【紹介する物の名前】\n紹介文．", $sentence);

        // DBに保存
        $place = new Place();
        $place->place = $sentence;
        $place->save();

        $info = new Info();
        $info->history = $response_history;
        $info->nature = $response_nature;
        $info->food = $response_food;

        $place->info()->save($info);

        // return view('chat.create', compact('sentence', 'response_history', 'response_nature', 'response_food'));
        return redirect("place/".$place->id);
    }

    /**
     * ChatGPT API呼び出し
     * Laravel HTTP
     */
    function chat_gpt($system, $user)
    {
        // ChatGPT APIのエンドポイントURL
        $url = "https://api.openai.com/v1/chat/completions";

        // APIキー
        $api_key = env('CHAT_GPT_KEY');

        // ヘッダー
        $headers = array(
            "Content-Type" => "application/json",
            "Authorization" => "Bearer $api_key"
        );

        // パラメータ
        $data = array(
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "system",
                    "content" => $system
                ],
                [
                    "role" => "user",
                    "content" => $user
                ]
            ]
        );

        $response = Http::withHeaders($headers)->post($url, $data);

        if ($response->json('error')) {
            // エラー
            return $response->json('error')['message'];
        }

        return $response->json('choices')[0]['message']['content'];
    }
}
