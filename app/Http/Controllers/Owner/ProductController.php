<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image; //単一ミドルウェアで使用
use Illuminate\Support\Facades\Auth; //単一ミドルウェアで使用
use App\Models\Product; //単一ミドルウェアで使用
use App\Models\SecondaryCategory; //単一ミドルウェアで使用
use App\Models\Owner; //単一ミドルウェアで使用


class ProductController extends Controller
{
    //ガード設定
    //ownersにログインしていたらの処理
    //コンストラクタで初期に実行される
    //コンストラクラのミドルウェアで、ログインしてるか確認するために必要
    public function __construct()
    {
        //⭐オーナーかどうかの判定ミドルウェア
        $this->middleware('auth:owners');

        //⭐アクセスした際に、ログインしてるオーナーのProduct情報が判定する単一ミドルウェア
        $this->middleware(function ($request, $next) {//$nextとは？　。$requestはミドルウェア関数内なので、Request　$requestは不要
            //dd($request); //$requestの中身確認
            //dd($request->route()); //$request->route()の中身確認
            //dd($request->route()->parameter('product')); //現在のproductIDを取得したい。Route::get('edit/{product}'の{product}の部分。文字列になってる。
            //dd(Auth::id()); //オーナーIDを取得。数字

            $id = $request->route()->parameter('product'); //productのid取得
            if(!is_null($id)){ // null判定
                $productsOwnerId = Product::findOrFail($id)->shop->owner->id; //ProductのオーナーID取得
                $productId = (int)$productsOwnerId; // キャスト 文字列→数値に型変換
                $ownerId = Auth::id(); //現在のオーナーID取得
                if($productId !== $ownerId){ // 同じでなかったら
                    abort(404); // 404画面表示
                }
            }

            return $next($request);
        });
    }



    public function index()
    {
        //⭐ログインしてるownerが使ってるProduct情報が取得できる（N+1問題あり）
        //$products = Owner::findOrFail(Auth::id())->shop->product; //現在のOwner(ID)->に紐づいてるshop->に紐づいてるproduct

        //⭐N+1問題解決
        //N+1問題を解決するためにEloquentのロード関係（Eager Loading）を使用
        //Ownerモデルに対してEager Loadingを行っています。これにより、Ownerモデルのインスタンスを取得する際に、関連するshopモデル、productモデル、およびimageFirstリレーションシップを事前にロードしておく
        //具体的には、以下の関係がロードされます：
            //shop: OwnerモデルとShopモデルの間のリレーションシップ
            //product: ShopモデルとProductモデルの間のリレーションシップ
            //imageFirst: ProductモデルとImageモデルの間のリレーションシップ
        //次に、->where('id', Auth::id())->get()で、特定のオーナーの情報を取得しています。Auth::id()は現在認証されているユーザーのIDを取得し、そのIDに一致するオーナーの情報を取得しています。
        $ownerInfo = Owner::with('shop.product.imageFirst')
        ->where('id', Auth::id())->get();

        //dd($ownerInfo);
        // foreach($ownerInfo as $owner){
        //     //dd($owner->shop->product);
        //     foreach($owner->shop->product as $product){
        //         dd($product->imageFirst->filename);
        //     }
        // }


        return view('owner.products.index', //ownerフォルダ.productsファイル.indexビューへ
        compact('ownerInfo')); //proucts変数を渡す
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}