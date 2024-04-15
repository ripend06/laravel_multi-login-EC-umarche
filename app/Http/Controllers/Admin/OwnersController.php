<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner; //Eloquent エロクアント
use App\Models\Shop; //Shopトランザクション
use Illuminate\Support\Facades\DB; //QueryBilder クエリビルダ
use Carbon\Carbon; //Carbrnインポート
use Illuminate\Support\Facades\Hash; //パスワードハッシュ（バリデーションで必要）
use Illuminate\Validation\Rules; //必要ぽい
use Throwable; //Shopトランザクション
use Illuminate\Support\Facades\Log; //Shopトランザクション


class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    //リソースコントローラーのミドルウェアを設定するたに必要
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    public function index()
    {
        //カーボン設定
        // $date_now = Carbon::now();
        // $date_parse = Carbon::parse(now());
        // echo $date_now->year; //現在の日付・時間。yearで年だけ表示。
        // echo $date_parse."\n";

        //Eloquent エロクアント
        //$e_all = Owner::all();
        //QueryBilder クエリビルダ
        //$q_get = DB::table('owners')->select('name', 'created_at')->get();
        //$q_first = DB::table('owners')->select('name')->first();
        //Collection コレクション
        // $c_test = collect([
        //     'name' => 'てすと'
        // ]);

        //var_dump($q_first);
        //
        //dd('オーナー一覧です'); //確認のための記述
        //dd($e_all, $q_get, $q_first, $c_test);


        $owners = Owner::select('id', 'name', 'email', 'created_at')
        //->get();
        ->paginate(3);



        return view('admin.owners.index',
        //compact('e_all', 'q_get'));
        compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.owners.create');
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'], //:adminsから、:ownersに変更
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //例外処理 Shopトランザクション
        try{
            DB::transaction(function() use($request) {
                $owner = Owner::create([ //:Ownersに
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                Shop::create([
                    'owner_id' => $owner->id,
                    'name' => '店名を入力してください',
                    'information' => '',
                    'filename' => '',
                    'is_selling' => true
                ]);
            },2); //NG時２回試す
        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }


        return redirect()
        ->route('admin.owners.index') //オーナー一覧にリダイレクト
        //->with('message', 'オーナー登録を実施しました。'); //オーナー一覧にリダイレクト
        ->with(['message' => 'オーナー登録を実施しました。',
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
    public function edit($id) //$idは何番目の情報が入ってる
    {
        $owner = Owner::findOrFail($id);
        //dd($owner);
        return view('admin.owners.edit', compact('owner'));
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
        $owner = Owner::findorFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();

        return redirect()
        ->route('admin.owners.index')
        //->with('message', 'オーナー情報を更新しました。');
        ->with(['message' => 'オーナー情報を更新しました。',
        'status' => 'info']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd('削除処理');
        Owner::findOrFail($id)->delete(); //ソフトデリート

        return redirect()
        ->route('admin.owners.index')
        ->with(['message' => 'オーナー情報を削除しました。',
        'status' => 'alert']);

    }

    //ソフトデリート
    public function expiredOwnerIndex(){
        $expiredOwners = Owner::onlyTrashed()->get();
        return view('admin.expired-owners',compact('expiredOwners'));
    }
    public function expiredOwnerDestroy($id){
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.expired-owners.index');
    }



}
