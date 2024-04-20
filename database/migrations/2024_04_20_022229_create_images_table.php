<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::create()メソッドを使用することで、データベースに新しいテーブルを作成し、そのテーブルの構造を定義
        Schema::create('images', function (Blueprint $table) { //、Schema::create()メソッドは、新しいテーブルを作成するために使用。テーブル名は、images
            $table->id();
            $table->foreignId('owner_id')
            ->constrained() //constrainedでFK（外部キー）を設定
            ->onUpdate('cascade') //deleteメソッドがある場合は必要。外部キー制約してるものは、一緒に削除されるように、onDelete（カスケード）が必要
            ->onDelete('cascade'); //deleteメソッドがある場合は必要。外部キー制約してるものは、一緒に削除されるように、onDelete（カスケード）が必要
            $table->string('filename');
            $table->string('title')->nullable(); //nullable()。値がなくてもOK
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
        Schema::dropIfExists('images');
    }
}
