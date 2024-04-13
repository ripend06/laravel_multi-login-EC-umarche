<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner; //Eloquent エロクアント
use Illuminate\Support\Facades\DB; //QueryBilder クエリビルダ
use Carbon\Carbon; //Carbrnインポート

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


        $owners = Owner::select('name', 'email', 'created_at')->get();



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
