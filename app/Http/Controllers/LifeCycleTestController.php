<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{
    //
    //サービスプロバイダ使ってみる
    public function showServiceProviderTest()
    {
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');

        $sample = app()->make('serviceProviderTest');

        dd($sample, $password, $encrypt->decrypt($password));
    }


    public function showServiceContainerTest()
    {
        //サービスコンテナ登録
        app()->bind('lifeCycleTest', function(){
            return 'ライフサイクルテスト';
        });

        //サービスコンテナから取り出す
        $test = app()->make('lifeCycleTest');


        //①サービスコンテナなしのパターン
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();

        //②サービスコンテナapp()ありのパターン
        app()->bind('sample', Sample::class);
        $sample = app()->make('sample');
        $sample->run();

        //サービスコンテナ確認
        dd($test, app());
    }
}

// Message クラス: メッセージを送信するクラス
class Message
{
    // メッセージを送信するメソッド
    public function send(){
        echo('メッセージ表示');
    }
}

// Sample クラス: Message クラスに依存するクラス
class Sample
{
    // Message インスタンスを格納するプロパティ
    public $message;

    // ★Message クラスのインスタンスを受け取るコンストラクタ
    public function __construct(Message $message){
        $this->message = $message;
    }

    // Message インスタンスの send() メソッドを実行するメソッド
    public function run(){
        $this->message->send();
    }
}
