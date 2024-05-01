<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //seederで利用


class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('t_stocks'): DBファサードのtable()メソッドを使用して、操作を行いたいテーブルを指定します。この場合、t_stocksテーブルが指定
        //insert([...]): insert()メソッドを使用して、指定されたデータをテーブルに挿入します。insert()メソッドの引数には、挿入するデータを含む配列が渡されます
        DB::table('t_stocks')->insert([
            [
                'product_id' => 1,
                'type' => 1,
                'quantity' => 5,
            ],
            [
                'product_id' => 1,
                'type' => 1,
                'quantity' => -2,
            ],
        ]);
    }
}
