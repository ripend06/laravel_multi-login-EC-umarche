<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes; //ソフトデリート用に追加
use App\Models\Shop; //リレーション用で追加
use App\Models\Image; //リレーション用で追加



class Owner extends Authenticatable
{
    use HasFactory, SoftDeletes; ////ソフトデリート用に追加

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //リレーション　owner:shop （1:1）
    public function shop()
    {
        return $this->hasone(Shop::class);
    }

    //リレーション　一旦　Owner:Images （1:多）
    public function image()
    {
        return $this->hasMany(Image::class);
    }
}
