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
            $table->string('name'); //string 短い文字列
            $table->text('information'); //text 長い文字列
            $table->unsignedInteger('price'); //unsignedInteger プラスの整数値
            $table->boolean('is_selling'); //boolean 真偽値
            $table->integer('sort_order')->nullable(); //integer 整数
            $table->foreignId('shop_id')
            ->constrained() //_idとあるので自動的にidを指定してる
            ->onUpdate('cascade') //⭐削除することがあればcascadeが必要
            ->onDelete('cascade'); //⭐削除することがあればcascadeが必要
            $table->foreignId('secondary_category_id')
            ->constrained(); //削除することがないので、cascadeが不要
            $table->foreignId('image1')  //削除することがないので、cascadeが不要
            ->nullable() //カラムが空を許可する
            ->constrained('images'); //自動で指定できないので、テーブル名を指定
            $table->foreignId('image2')  //削除することがないので、cascadeが不要
            ->nullable() //カラムが空を許可する
            ->constrained('images'); //自動で指定できないので、テーブル名を指定
            $table->foreignId('image3')  //削除することがないので、cascadeが不要
            ->nullable() //カラムが空を許可する
            ->constrained('images'); //自動で指定できないので、テーブル名を指定
            $table->foreignId('image4')  //削除することがないので、cascadeが不要
            ->nullable() //カラムが空を許可する
            ->constrained('images'); //自動で指定できないので、テーブル名を指定
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
