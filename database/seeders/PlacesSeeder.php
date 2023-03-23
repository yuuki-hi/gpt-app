<?php

namespace Database\Seeders;

use App\Models\Tweet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // placesテーブルに地名を挿入
        DB::table('places')->insert([
            ['place' => '日光'],
            ['place' => '箱根'],
        ]);

        // place_infosテーブルに情報を挿入
        DB::table('infos')->insert([
            [
                'place_id' => 1,
                'history' => '【輪王寺】 日光東照宮の裏手に位置する、真言宗豊山派の寺院。江戸時代初期に徳川家康の命により創建された。',
                'nature' => '1. 華厳の滝 - 日光国立公園に位置する、高さ97メートルの滝。',
                'food' => '【銀座ロールの日光店】 銀座ロールは、日光市内でも人気の洋菓子店です'
            ],
            [
                'place_id' => 1,
                'history' => '【輪王寺】 日光東照宮の裏手に位置する、真言宗豊山派の寺院。江戸時代初期に徳川家康の命により創建された。',
                'nature' => '1. 華厳の滝 - 日光国立公園に位置する、高さ97メートルの滝。',
                'food' => '【銀座ロールの日光店】 銀座ロールは、日光市内でも人気の洋菓子店です'
            ],
            [
                'place_id' => 2,
                'history' => '【輪王寺】 日光東照宮の裏手に位置する、真言宗豊山派の寺院。江戸時代初期に徳川家康の命により創建された。',
                'nature' => '1. 華厳の滝 - 日光国立公園に位置する、高さ97メートルの滝。',
                'food' => '【銀座ロールの日光店】 銀座ロールは、日光市内でも人気の洋菓子店です'
            ],
        ]);
    }
}
