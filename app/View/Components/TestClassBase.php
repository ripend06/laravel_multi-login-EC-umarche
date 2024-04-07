<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TestClassBase extends Component
{
    public $classBaseMessage; //定義
    public $defaultMessage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classBaseMessage, $defaultMessage="初期値です。") //インスタンスでされたら実行
    {
        $this->classBaseMessage = $classBaseMessage; //クラスを使用する際に、classBaseMessageという箱を作ってくれる
        $this->defaultMessage = $defaultMessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() //コンストラクタで設定してる場合は、こっっちで設定しなくてもOK
    {
        return view('components.tests.test-class-base');
    }
}
