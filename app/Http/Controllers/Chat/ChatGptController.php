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

        $sentence_place = "$sentence";

        // ChatGPT API処理
        $sentence_system = "You are an excellent tour conductor.";
        $sentence_assistant = "
        The output should be a markdown code snippet formatted in the following schema in Japanese:
        
        [
          {
             place: string, // name of tourist spot
             info: string // description of the place.
          },
          {
             place: string, // name of tourist spot
             info: string // description of the place.
          }
        ]
        
        NOTES:
        * Do not include place that do not exist.
        * Please do not include anything other than JSON in your answer.
        * Response must be Japanese.";

        $sentence_history = "$sentence_place に行きたいです。おすすめの歴史に関する観光地を検索してください。What 5 places do you recommend?";
        $sentence_nature = "$sentence_place に行きたいです。おすすめの自然に関する観光地を検索してください。What 5 places do you recommend?";
        $sentence_food = "$sentence_place に行きたいです。おすすめのご当地グルメを検索してください。What 5 places do you recommend?";

        $response_history = $this->chat_gpt($sentence_system, $sentence_assistant, $sentence_history);
        $response_nature = $this->chat_gpt($sentence_system, $sentence_assistant, $sentence_nature);
        $response_food = $this->chat_gpt($sentence_system, $sentence_assistant, $sentence_food);

        // $response_nature = $this->chat_gpt("次の地名について，自然に関する観光地(温泉や湖，川，山，滝，森など)をいくつか紹介してください．絶対に次の例のように書いてください．例:\n【紹介する物の名前】\n紹介文．", $sentence);
        // $response_food = $this->chat_gpt("次の地名について，おすすめグルメや食文化をいくつか紹介してください．絶対に次の例のように書いてください．例:\n【紹介する物の名前】\n紹介文．", $sentence);

        // DBに保存
        $place = new Place();
        $place->place = $sentence_place;
        $place->save();

        $info = new Info();
        $info->history = $response_history;
        $info->nature = $response_nature;
        $info->food = $response_food;

        $place->info()->save($info);

        // return view('chat.create', compact('sentence', 'response_history', 'response_nature', 'response_food'));
        return redirect("place/" . $place->id);
    }

    /**
     * ChatGPT API呼び出し
     * Laravel HTTP
     */
    function chat_gpt($system, $assistant, $user)
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
                    "role" => "assistant",
                    "content" => $assistant
                ],
                [
                    "role" => "user",
                    "content" => $user
                ]
            ]
        );

        $response = Http::withHeaders($headers)->timeout(60)->post($url, $data);
        if ($response->json('error')) {
            // エラー
            return $response->json('error')['message'];
        }

        $json = $this->get_json_from_sentence($response->json('choices')[0]['message']['content']);
        return $json;
    }

    /*
    * 文字列からjson形式の文字列を取り出し，jsonオブジェクトを返す
    */
    function get_json_from_sentence($input)
    {
        // 先頭のJSON以外のデータを取り除く
        $first_json_pos = strpos($input, '[');
        if ($first_json_pos !== false) {
            $input = substr($input, $first_json_pos);
        }

        // 末尾のJSON以外のデータを取り除く
        $last_json_pos = strrpos($input, ']');
        if ($last_json_pos !== false) {
            $input = substr($input, 0, $last_json_pos + 1);
        }

        // 末尾に余計なカンマがあったら取り除く
        $input = preg_replace('/,\s*([\]}])/m', '$1', $input);

        // この段階ではjson形式の文字列 (json_encodeすればjsonになる)
        $json_str = $input;


        if ($json_str === null) {
            // JSONのデコードに失敗した場合の処理
            return json_encode([]);
        } else {
            return $json_str;
        }
    }
}
