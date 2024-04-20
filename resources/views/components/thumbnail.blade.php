@php
if($type === 'shops'){
    $path = 'storage/shops/';
}
if($type === 'products'){
    $path = 'storage/products/';
}

@endphp

<div>
    {{-- $shop->filename 画像名前が、空じゃなかったらの条件 --}}
    @if(empty($filename))
        <img src="{{ asset('images/no_image.jpg') }}">
    @else
        {{-- $shop->filename 画像名を表示 --}}
        <img src="{{ asset($path . $filename ) }}">
    @endif
</div>