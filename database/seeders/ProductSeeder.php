<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //seederで利用


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('products'): DBファサードのtable()メソッドを使用して、操作を行いたいテーブルを指定します。この場合、productsテーブルが指定
        //insert([...]): insert()メソッドを使用して、指定されたデータをテーブルに挿入します。insert()メソッドの引数には、挿入するデータを含む配列が渡されます
        DB::table('products')->insert([
            [
                'shop_id' => 1,
                'secondary_category_id' => 1,
                'image1' => 1,
            ],
            [
                'shop_id' => 1,
                'secondary_category_id' => 2,
                'image1' => 2,
            ],
            [
                'shop_id' => 1,
                'secondary_category_id' => 3,
                'image1' => 3,
            ],
            [
                'shop_id' => 1,
                'secondary_category_id' => 4,
                'image1' => 3,
            ],
            [
                'shop_id' => 1,
                'secondary_category_id' => 5,
                'image1' => 4,
            ],
        ]);
    }
}
