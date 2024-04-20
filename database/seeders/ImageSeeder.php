<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //seederで利用


class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('images'): DBファサードのtable()メソッドを使用して、操作を行いたいテーブルを指定します。この場合、imagesテーブルが指定
        //insert([...]): insert()メソッドを使用して、指定されたデータをテーブルに挿入します。insert()メソッドの引数には、挿入するデータを含む配列が渡されます
        DB::table('images')->insert([
            [
                'owner_id' => 1,
                'filename' => 'sample1.jpg',
                'title' => null
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample2.jpg',
                'title' => null
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample3.jpg',
                'title' => null
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample4.jpg',
                'title' => null
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample5.jpg',
                'title' => null
            ],
            [
                'owner_id' => 1,
                'filename' => 'sample6.jpg',
                'title' => null
            ],
        ]);
    }
}
