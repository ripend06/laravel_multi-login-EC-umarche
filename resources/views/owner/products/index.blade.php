<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- フラッシュメッセージ表示 flash-messageコンポーネント --}}
                    <x-flash-message status="session('status')" />
                    <div class="flex justify-end mb-4">
                        <button onclick="location.href='{{ route('owner.products.create') }}'" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録する</button>
                    </div>
                    {{-- blade内では、@foreachでforeach使える --}}
                    {{-- ownerフォルダ.productファイル.editメソッド --}}
                    {{-- editには、idパラメータが必要 ['product' => $product->id] --}}
                    {{-- 'product'はキー --}}
                    {{-- foreach2重で回す必要あり --}}
                    <div class="flex flex-wrap">
                    @foreach($ownerInfo as $owner)
                        @foreach($owner->shop->product as $product)
                            <div class="w-1/4 p-2 md:p-4">
                                <a href="{{ route('owner.products.edit', ['product' => $product->id]) }}">
                                    <div class="border rounded-md p-2 md:p-4">
                                        {{-- $product->title 画像名を表示 --}}
                                        {{-- コンポーネントにプロパティ属性を渡す。productに紐づいてるimaegFirstに紐づいてるfilenameを表示 :filename="$product->imaegFirst->filename"  --}}
                                        {{-- コンポーネントに文字列を渡すので：不要。 filename="{{$product->imageFirst->filename ?? ''}}"  imageFirst(image1)のfilenameがnullだったら空に。 --}}
                                        {{-- <x-thumbnail :filename="$product->imageFirst->filename" type="products"/> --}}
                                        <x-thumbnail filename="{{$product->imageFirst->filename ?? ''}}" type="products"/>
                                        <div class="text-gray-700">{{ $product->name}}</div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endforeach
                    </div>
                    {{-- ページネーション --}}
                    {{-- $images->links(); --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
