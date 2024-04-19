@props(['status' => 'info']) {{--初期値設定--}}

{{-- sessionから、statusを受け取る。条件分岐で、カラーを変えて変数にいれる --}}
@php
if(session('status') === 'info'){ $bgColor = 'bg-blue-300';}
if(session('status') === 'alert'){ $bgColor = 'bg-red-500';}
@endphp

{{-- sessionから、受け取ったmessageがあれば、表示 --}}
@if(session('message'))
    <div class="{{ $bgColor }} w-1/2 mx-auto p-2 text-white">
        {{ session('message' )}}
    </div>
@endif