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
        $response_history = $this->chat_gpt("次の地名の｢歴史的な観光地｣を検索し，簡単な紹介文を作ってください．日本語で応答してください．箇条書きで書いてください．", $sentence);

        $response_nature = $this->chat_gpt("次の地名の｢自然が有名な観光地｣を検索し，簡単な紹介文を作ってください．日本語で応答してください．箇条書きで書いてください．", $sentence);

        $response_food = $this->chat_gpt("次の地名の｢おすすめグルメ｣を検索し，簡単な紹介文を作ってください．日本語で応答してください．箇条書きで書いてください．", $sentence);

        // DBに保存
        $place = new Place();
        $place->place = $sentence;
        $place->save();

        $info = new Info();
        $info->history = $response_history;
        $info->nature = $response_nature;
        $info->food = $response_food;

        $place->info()->save($info);

        return view('chat.create', compact('sentence', 'response_history', 'response_nature', 'response_food'));
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
