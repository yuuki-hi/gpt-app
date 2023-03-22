<?php

namespace Database\Seeders;

use App\Models\Tweet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class TweetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // placesテーブルに地名を挿入
        DB::table('places')->insert([
            ['name' => '日光'],
            ['name' => '箱根'],
        ]);

        // place_infosテーブルに情報を挿入
        DB::table('place_infos')->insert([
            ['place_id' => 1, 'color' => '赤', 'animal' => '犬', 'number' => 20],
            ['place_id' => 1, 'color' => '青', 'animal' => '猫', 'number' => 25],
            ['place_id' => 1, 'color' => '緑', 'animal' => '猿', 'number' => 18],
            ['place_id' => 2, 'color' => '黄色', 'animal' => '鳥', 'number' => 20],
            ['place_id' => 2, 'color' => '白', 'animal' => '魚', 'number' => 80],
        ]);
    }
}
