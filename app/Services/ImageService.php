<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage; //画像アップロードに必要
use InterventionImage; //InterventionImageライブラリで必要


class ImageService
{
    public static function upload($imageFile, $folderName){ //第一引数：ファイル名。第二引数：フォルダ名

        //リサイズありの場合
        $fileName = uniqid(rand().'_'); //ランダムの文字列を生成
        $extension = $imageFile->extension(); //一次保存されてる画像の拡張子を取得
        $fileNameToStore = $fileName. '.' . $extension; //ファイル名と拡張子をくっつけて

        $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode(); //画像リサイズ処理

        //putメソッドは、ファイルの内容をディスクに保存するために使用します。
        Storage::put('public/'. $folderName . '/' . $fileNameToStore,$resizedImage ); //第一引数：フォルダ名ファイル名。第二引数：リサイズしたがオズ



        return $fileNameToStore; //作ったファイル名を返してDBに保存できる
    }
}