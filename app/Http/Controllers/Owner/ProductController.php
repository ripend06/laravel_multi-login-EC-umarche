<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image; //単一ミドルウェアで使用
use Illuminate\Support\Facades\DB; //QueryBilder クエリビルダ
use Illuminate\Support\Facades\Auth; //単一ミドルウェアで使用
use App\Models\Product; //単一ミドルウェアで使用
use App\Models\PrimaryCategory; //単一ミドルウェアで使用
use App\Models\Shop; //単一ミドルウェアで使用
use App\Models\Owner; //単一ミドルウェアで使用
use App\Models\Stock; //単一ミドルウェアで使用


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
    public function create() //createメソッドを使ってユーザーが新しい商品を投稿を作成できるページを提供する
    {
        //①owner_idというカラムが、現在ログインしているユーザーのID (Auth::id()) と等しい条件を指定し、
            //where()メソッド
            //第一引数: カラム名
            //データベースのテーブルのカラム名を指定します。これは条件として使用されます。
            //第二引数: 条件値
            //第一引数で指定したカラムと比較される値を指定します。条件に合致するレコードが抽出されます。
        //②selectメソッドで取得する列を指定し、
        //③getメソッドで実際にデータを取得
        $shops = Shop::where('owner_id', Auth::id()) //Auth::id()は現在ログインしているユーザーのIDを取得
        ->select('id', 'name')
        ->get();


        //①owner_idというカラムが、現在ログインしているユーザーのID (Auth::id()) と等しい条件を指定し、
        //②selectメソッドで取得する列を指定し、
        //③orderByで、updated_atを降順で並び替えて、
        //④getメソッドで実際にデータを取得
        $images = Image::where('owner_id', Auth::id())
        ->select('id', 'title', 'filename')
        ->orderBy('updated_at', 'desc')
        ->get();


        //⭐ログインしてるownerが使ってるPrimaryCategoryモデルの各レコードに関連するsecondaryモデルのデータも取得される（N+1問題あり）
        //Eloquent ORM（Laravelのデータベース操作ライブラリ）を使用して、PrimaryCategoryモデルの全てのレコードを取得しています。
        //また、withメソッドを使って、PrimaryCategoryモデルと関連するsecondaryモデルのデータも同時に取得

        //⭐N+1問題解決
        //N+1問題を解決するためにEloquentのロード関係（Eager Loading）を使用
        //PrimaryCategoryモデルに対してEager Loadingを行っています。これにより、PrimaryCategoryモデルのインスタンスを取得する際に、関連するsecondaryリレーションシップを事前にロードしておく
        //具体的には、以下の関係がロードされます：
            //secondary: PrimaryCategoryデルとsecondaryモデルの間のリレーションシップ
        $categories = PrimaryCategory::with('secondary')
        ->get();


        //'shops', 'images', 'categories'の変数をownerフォルダ.poductフォルダ.createビューに渡す
        return view('owner.products.create',
            compact('shops', 'images', 'categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        //バリデーション
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'information' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'integer'],
            'sort_order' => ['nullable', 'integer'], //nullable 空であってもバリデーションを通過
            'quantity' => ['required', 'integer'],
            //Laravelのバリデーションルールの一つで、指定されたデータベーステーブル内に特定の値が存在することを確認するために使用。
            //shop_idフィールドの値がshopsテーブルのidカラムに存在することを確認
            'shop_id' => ['required', 'exists:shops,id'],
            //Laravelのバリデーションルールの一つで、指定されたデータベーステーブル内に特定の値が存在することを確認するために使用。
            //shop_idフィールドの値がsecondary_categoriesテーブルのidカラムに存在することを確認
            'category' => ['required', 'exists:secondary_categories,id'],
            //Laravelのバリデーションルールの一つで、指定されたデータベーステーブル内に特定の値が存在することを確認するために使用。
            //shop_idフィールドの値がimagesテーブルのidカラムに存在することを確認
            'image1' => ['nullable', 'exists:images,id'],
            'image2' => ['nullable', 'exists:images,id'],
            'image3' => ['nullable', 'exists:images,id'],
            'image4' => ['nullable', 'exists:images,id'],
            'is_selling' => ['nullable'],
        ]);

        //例外処理 Productトランザクション
        try{
            DB::transaction(function() use($request) {
                $product = Product::create([ //新しいPproductのレコードを追加
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'sort_order' => $request->sort_order,
                    'shop_id' => $request->shop_id,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                    'is_selling' => $request->is_selling,
                ]);

                Stock::create([ //新しいStockのレコードを追加
                    'product_id' => $product->id,
                    'type' => 1,
                    'quantity' => $request->quantity,
                ]);
            },2); //NG時２回試す
        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }


        return redirect()
        ->route('owner.products.index') //商品一覧一覧にリダイレクト
        //リダイレクト時にセッションにデータをフラッシュするために使用されます。
        //このメソッドは、リダイレクト先のページに一時的なデータを渡す
        //フラッシュメッセージ
        ->with(['message' => '商品登録しました。',
        'status' => 'info']);
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
