<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image; //単一ミドルウェアで使用
use Illuminate\Support\Facades\Auth; //単一ミドルウェアで使用
use App\Http\Requests\UploadImageRequest; //フォームリクエスト(バリデーション)で必要
use App\Services\ImageService; //サービス切り離しで必要




class ImageController extends Controller
{


    //ガード設定
    //ownersにログインしていたらの処理
    //コンストラクタで初期に実行される
    //コンストラクラのミドルウェアで、ログインしてるか確認するために必要
    public function __construct()
    {
        //⭐オーナーかどうかの判定ミドルウェア
        $this->middleware('auth:owners');

        //⭐アクセスした際に、ログインしてるオーナーのImage情報が判定する単一ミドルウェア
        $this->middleware(function ($request, $next) {//$nextとは？　。$requestはミドルウェア関数内なので、Request　$requestは不要
            //dd($request); //$requestの中身確認
            //dd($request->route()); //$request->route()の中身確認
            //dd($request->route()->parameter('image')); //現在のimageIDを取得したい。Route::get('edit/{image}'の{image}の部分。文字列になってる。
            //dd(Auth::id()); //オーナーIDを取得。数字

            $id = $request->route()->parameter('image'); //shopのid取得
            if(!is_null($id)){ // null判定
                $imagesOwnerId = Image::findOrFail($id)->owner->id; //ImageのオーナーID取得
                $imageId = (int)$imagesOwnerId; // キャスト 文字列→数値に型変換
                $ownerId = Auth::id(); //現在のオーナーID取得
                if($imageId !== $ownerId){ // 同じでなかったら
                    abort(404); // 404画面表示
                }
            }

            return $next($request);
        });
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //⭐ログインしているオーナーが所有する画像の一覧を表示するためのデータが取得
        //ログインしてるオーナーのIDが取得できる
        // Auth::id(); Laravelファザードというシステム
        $ownerId = Auth::id(); // 認証されているid。IDが単数の場合有効
        //Eloquentメソッドで、shopモデルの、owner_idカラムから、$ownerIdに一致するレコードを検索
        //whereメソッドの第一引数は、検索条件のカラム名を指定します。第二引数は、そのカラムに対する条件を指定
        $images = Image::where('owner_id', $ownerId)// whereは検索条件。IDが複数の場合有効
        ->orderBy('updated_at', 'desc') //降順に並び替え
        ->paginate(20); //２０件ごとに分割

        return view('owner.images.index', //ownerフォルダのimagesファイルのindexメソッドを表示
        compact('images')); //compactで、images変数を渡す
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        //dd($request); //確認
        $imageFiles = $request->file('files'); //複数の画像を取得
        if(!is_null($imageFiles)){ //imageFilesが空じゃなかったらの処理
            foreach($imageFiles as $imageFile){ //foreachでひとつひとつ処理
                //⭐サービス切り離し
                $fileNameToStore = ImageService::upload($imageFile, 'products'); //画像名が返ってくる
                Image::create([ //createメソッドで、連想配列にして保存
                    'owner_id' => Auth::id(), //現在のオーナーID
                    'filename' => $fileNameToStore //サービス切り離しで戻ってきた画像名
                ]);
            }
        }

        //リダイレクト処理
        return redirect()
        ->route('owner.images.index') //ownerフォルダ、imagesファイル、indexビューにリダイレクト
        ->with(['message' => '画像登録を実施しました。', //リダイレクト先に、フラッシュメッセージを追加　
        'status' => 'info']); //messageとstatusという名前のセッション変数にそれぞれ値を設定

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
