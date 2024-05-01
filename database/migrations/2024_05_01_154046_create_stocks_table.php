<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_stocks', function (Blueprint $table) { //t_stock トランザクションテーブル用
            $table->id();
            $table->foreignId('product_id')
            ->constrained()
            ->onUpdate('cascade') //⭐削除することがあればcascadeが必要
            ->onDelete('cascade'); //⭐削除することがあればcascadeが必要
            $table->tinyInteger('type');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_stocks');
    }
}
