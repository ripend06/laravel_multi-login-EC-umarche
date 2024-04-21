<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //callは、Laravelのデータベースシーディング機能を使用して、データベースに初期データを挿入するために使用されるメソッド
        //シーダーの呼び出し
        $this->call([
            AdminSeeder::class, //アドミンシーダー
            OwnerSeeder::class, //オーナーシーダー
            ShopSeeder::class, //店舗シーダー
            ImageSeeder::class, //画像シーダー
            CategorySeeder::class, //カテゴリシーダー
        ]);
    }
}
