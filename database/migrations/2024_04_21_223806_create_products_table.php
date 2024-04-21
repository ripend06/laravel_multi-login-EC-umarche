<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')
            ->constrained()
            ->onUpdate('cascade') //⭐削除することがあればcascadeが必要
            ->onDelete('cascade'); //⭐削除することがあればcascadeが必要
            $table->foreignId('secondary_category_id')
            ->constrained(); //削除することがないので、cascadeが不要
            $table->foreignId('image1')  //削除することがないので、cascadeが不要
            ->nullable() //カラムが空を許可する
            ->constrained('images'); //テーブル名を指定
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
        Schema::dropIfExists('products');
    }
}
