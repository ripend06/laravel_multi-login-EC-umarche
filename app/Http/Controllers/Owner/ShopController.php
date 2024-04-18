<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage; //画像アップロードに必要

class ShopController extends Controller
{
    //ガード設定
    //ownersにログインしていたらの処理
    //コンストラクタで初期に実行される
    //コンストラクラのミドルウェアで、ログインしてるか確認するために必要
    public function __construct()
    {
        //オーナーかどうかの判定ミドルウェア
        $this->middleware('auth:owners');

        //アクセスした際に、ログインしてるオーナーのShop情報が判定するミドルウェア
        $this->middleware(function ($request, $next) {//$nextとは？　。$requestはミドルウェア関数内なので、Request　$requestは不要
            //dd($request); //$requestの中身確認
            //dd($request->route()); //$request->route()の中身確認
            //dd($request->route()->parameter('shop')); //現在のshopIDを取得したい。Route::get('edit/{shop}'の{shop}の部分。文字列になってる。
            //dd(Auth::id()); //オーナーIDを取得。数字

            $id = $request->route()->parameter('shop'); //shopのid取得
            if(!is_null($id)){ // null判定
                $shopsOwnerId = Shop::findOrFail($id)->owner->id; //ShopのオーナーID取得
                $shopId = (int)$shopsOwnerId; // キャスト 文字列→数値に型変換
                $ownerId = Auth::id(); //現在のオーナーID取得
                if($shopId !== $ownerId){ // 同じでなかったら
                    abort(404); // 404画面表示
                }
            }

            return $next($request);
        });
    }


    public function index()
    {
        //ログインしてるオーナーのIDが取得できる
        //Laravelファザードというシステム
        $ownerId = Auth::id(); // 認証されているid。IDが単数の場合有効
        //Eloquentメソッドで、shopモデルの、owner_idカラムから、$ownerIdに一致するレコードを検索
        //whereメソッドの第一引数は、検索条件のカラム名を指定します。第二引数は、そのカラムに対する条件を指定
        $shops = Shop::where('owner_id', $ownerId)->get(); // whereは検索条件。IDが複数の場合有効

        return view('owner.shops.index', //ownerフォルダのshopsファイルのindexメソッドを表示
        compact('shops')); //compactで、shops変数を渡す
    }

    //$idはどこからきた？
    //ルーティングの、Route::get('/shops/{id}/edit', 'ShopController@edit');から、idが自動的にメソッドが渡される
    public function edit($id)
    {
        //EloquentモデルのメソッドのfindOrFail、findOrFail($id)でIDがあれば表示、なければ４０４
        //ddは、デバッグ用関数
        //dd(Shop::findOrFail($id));

        //Shopモデルから、idがあれば、取り出す
        $shop = Shop::findOrfail($id);
        //ownerフォルダ.shopsファイル.editブレード返す。Shopの変数も渡して
        return view('owner.shops.edit', compact('shop'));
    }

    //Request $requestはどこからきた？
    //use Illuminate\Http\Request;で読み込んで使えるようにしてる
    public function update(Request $request, $id)
    {
        $imageFile = $request->image; //一時保存　されてる画像を取得
        if(!is_null($imageFile) && $imageFile->isValid() ){ //画像がnullじゃなかったら＋アップロードできてるかの条件
            Storage::putFile('public/shops', $imageFile); //storage/public/shopsフォルダ内に、$imageFileを保存する
        }

        return redirect()->route('owner.shops.index'); //ownerフォルダ、shopsファイル、indexビューにリダイレクト
    }

}
