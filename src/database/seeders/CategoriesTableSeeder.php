<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'ファッション'],
            ['name' => 'レディース'],
            ['name' => 'メンズ'],
            ['name' => 'ベビー/キッズ'],
            ['name' => 'ゲーム/おもちゃ'],
            ['name' => 'ホビー'],
            ['name' => '楽器'],
            ['name' => '本/雑誌/漫画'],
            ['name' => 'CD/DVD/ブルーレイ'],
            ['name' => 'スマホ/タブレット'],
            ['name' => 'テレビ/オーディオ'],
            ['name' => '生活家電'],
            ['name' => 'スポーツ'],
            ['name' => 'アウトドア'],
            ['name' => '旅行用品'],
            ['name' => 'コスメ/美容'],
            ['name' => 'ダイエット/健康'],
            ['name' => '食品/飲料'],
            ['name' => 'キッチン/日用品'],
            ['name' => '家具/インテリア'],
            ['name' => 'ペット用品'],
            ['name' => 'DIY/工具'],
            ['name' => 'ガーデニング'],
            ['name' => 'ハンドメイド'],
            ['name' => '車/バイク/自転車'],
            ['name' => 'その他'],
        ]);
    }
}
