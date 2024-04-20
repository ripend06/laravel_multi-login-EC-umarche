<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage; //画像アップロードに必要
use InterventionImage; //InterventionImageライブラリで必要


class ImageService
{
    public static function upload($imageFile, $folderName){ //第一引数：ファイル名。第二引数：フォルダ名

        //dd($imageFile['image']);

        //⭐画像が複数ある場合（配列）
        if(is_array($imageFile)) //is_array()は、imageFileが配列だった場合
        {
            $file = $imageFile['image']; //$imageFile['image']で複数のファイルを取得できる
        } else {
            $file = $imageFile;
        }

        //リサイズありの場合
        $fileName = uniqid(rand().'_'); //ランダムの文字列を生成
        $extension = $file->extension(); //一次保存されてる画像の拡張子を取得
        $fileNameToStore = $fileName. '.' . $extension; //ファイル名と拡張子をくっつけて

        $resizedImage = InterventionImage::make($file)->resize(1920, 1080)->encode(); //画像リサイズ処理

        //putメソッドは、ファイルの内容をディスクに保存するために使用します。
        Storage::put('public/'. $folderName . '/' . $fileNameToStore,$resizedImage ); //第一引数：フォルダ名ファイル名。第二引数：リサイズしたがオズ



        return $fileNameToStore; //作ったファイル名を返してDBに保存できる
    }
}