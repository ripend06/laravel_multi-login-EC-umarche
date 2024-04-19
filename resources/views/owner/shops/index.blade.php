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
                    {{ フラッシュメッセージ表示 flash-messageコンポーネント }}
                    <x-flash-message status="session('status')" />
                    {{-- blade内では、@foreachでforeach使える --}}
                    {{-- ownerフォルダ.shopsファイル.editメソッド --}}
                    {{-- editには、idパラメータが必要 ['shop' => $shop->id] --}}
                    {{-- 'shop'はキー --}}
                    @foreach ($shops as $shop)
                        <div class="w-1/2 p-4">
                            <a href="{{ route('owner.shops.edit', ['shop' => $shop->id]) }}">
                                <div class="border rounded-md p-4">
                                    <div class="mb-4">
                                    {{-- $shop->is_sellingは、販売中かのパラメータ --}}
                                    @if($shop->is_selling)
                                        <span class="border p-2 round-md bg-blue-400 text-white">販売中</span>
                                    @else
                                        <span class="border p-2 round-md bg-red-400 text-white">停止中</span>
                                    @endif
                                    </div>
                                    {{-- $shop->name ショップ名を表示 --}}
                                    {{-- コンポーネントにプロパティ属性を渡す :filename="$shop->filename"  --}}
                                    <div class="text-x1">{{ $shop->name}}</div>
                                    <x-shop-thumbnail :filename="$shop->filename" />
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
