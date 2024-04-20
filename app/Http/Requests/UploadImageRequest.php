<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() //認証されてるユーザーが使えるかどうか
    {
        return true; //基本はtrue
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() //バリデーションルールを書く必要がある
    {
        return [
            //バリデーション
            //image 画像である
            //mimes:jpg,jpeg,png jpgかpngである
            //max:2048　MAX２メガバイトまで
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',

            //ImageStoreメソッドで使用
            //create.blade.phpの　name="files[][image]"　と同じ記述にする必要がある
            //filesという名前の配列内の各要素に対して行う
            //'files.*.image'は、「files配列内のすべての要素のimage属性」に対するバリデーションルールを指定
            'files.*.image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    //バリデーションのエラーをつけれる
    public function messages()
    {
        return [
            'image' => '指定されたファイルが画像ではありません。',
            'mines' => '指定された拡張子（jpg/jpeg/png）ではありません。',
            'max' => 'ファイルサイズは2MB以内にしてください。',
        ];
    }

}
