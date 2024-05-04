<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 't_stocks'; //トランザクションテーブル用

    protected $fillable = [ //fillableプロパティを使用することで、モデルに一括代入を許可する属性を明示的に指定
        'product_id',
        'type',
        'quantity',
    ];
}
