<?php

namespace App\Models;
use App\Models\Shop; //リレーション用で追加
use App\Models\SecondaryCategory; //リレーション用で追加
use App\Models\Image; //リレーション用で追加
use App\Models\Stock; //リレーション用で追加


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //リレーション　product:shop （多:1）
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    //リレーション　product:secondaryCategory （多:1）
    //⭐メソッド名をsecondaryCategoryから省略したので、どれに紐づいてるのかわからないので、
    //第二引数にsecondary_category_id記述必要
    public function category()
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }

    //リレーション　product:iamge1 （多:1）
    public function imageFirst() //⭐image1だと、同じカラム名でエラーでるので名前変える必要ある
    {
        return $this->belongsTo(Image::class, 'image1', 'id'); //⭐第二引数で、FK。第三引数で紐づけるカラム名を指定。imageモデルのIDと紐づく
    }

    //リレーション　product:stock （1:多）
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

}
