<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PrimaryCategory; //リレーション用で追加


class SecondaryCategory extends Model
{
    use HasFactory;


    //リレーション　PrimaryCategory:SecondCategory （1:多）
    public function primary()
    {
        return $this->belongsTo(PrimaryCategory::class);
    }
}
