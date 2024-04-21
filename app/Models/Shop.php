<?php

namespace App\Models;
use App\Models\Owner; //リレーション用で追加
use App\Models\Product; //リレーション用で追加

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'information',
        'filename',
        'is_selling'
    ];

    //リレーション　owner:shop （1:1）
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    //リレーション　shop:product （1:多）
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
