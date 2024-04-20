<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner; //リレーション設定で必要

class Image extends Model
{
    use HasFactory;

    //Eloquentモデルの属性（カラム）を一括代入可能なものとして指定するために使用されます。
    //Imageモデルで使うカラム名を書く
    protected $fillable = [
        'owner_id',
        'filename',
    ];

    //リレーション　一旦　Owner:Images （1:多）
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

}
