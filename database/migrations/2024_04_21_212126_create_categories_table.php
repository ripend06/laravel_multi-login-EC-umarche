<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration //ファイル名を変えたのでクラス名も変える必要あり
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order');
            $table->timestamps();
        });

        Schema::create('secondary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order');
            $table->foreignId('primary_category_id')
            ->constrained(); //外部キー制約
            //->onUpdate('cascade') //⭐削除することがないのでcascadeが不要
            //->onDelete('cascade'); //⭐削除することがないのでcascadeが不要
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
        //⭐外部キー制約をしてるので、secondary_categoriesから削除が必要
        Schema::dropIfExists('secondary_categories');

        Schema::dropIfExists('primary_categories');

    }
}
