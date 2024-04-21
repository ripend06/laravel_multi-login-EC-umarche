<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SecondaryCategory; //リレーション用で追加


class PrimaryCategory extends Model
{
    use HasFactory;

    //リレーション　PrimaryCategory:SecondCategory （1:多）
    public function secondary()
    {
        return $this->hasMany(SecondaryCategory::class);
    }
}
