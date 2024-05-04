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
                    {{-- actionでupdateに渡す。 {{ route('owner.products.update') }} --}}
                    {{-- バリデーションを作成 --}}
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="post" action="{{ route('owner.products.store') }}">
                    @csrf
                        <div class="-m-2">
                            {{-- 商品名 --}}
                            {{-- value="{{ old('name') }}" で ヴァリデーションで弾かれたときの値を表示 --}}
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" require class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            {{-- 商品情報 --}}
                            {{-- {{ old('information') }} で 商品情報表示 --}}
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                                    <textarea id="information" name="information" rows="10" require class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('information') }}</textarea>
                                </div>
                            </div>
                            {{-- 価格 --}}
                            {{-- value="{{ old('price') }}" で ヴァリデーションで弾かれたときの値を表示 --}}
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                                    <input type="number" id="price" name="price" value="{{ old('price') }}" require class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            {{-- 表示順 --}}
                            {{-- value="{{ old('sort_order') }}" で ヴァリデーションで弾かれたときの値を表示 --}}
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            {{-- 表示順 --}}
                            {{-- value="{{ old('sort_order') }}" で ヴァリデーションで弾かれたときの値を表示 --}}
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="quantity" class="leading-7 text-sm text-gray-600">初期在庫 ※必須</label>
                                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" require class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            {{-- 商品名 --}}
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="shop_id" class="leading-7 text-sm text-gray-600">販売する店舗</label>
                                    <select name="shop_id" id="shop_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        @foreach($shops as $shop)
                                        <option value="{{ $shop->id}}">
                                            {{ $shop->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- 店名情報 --}}
                            {{-- optgroupタグ で ラベルを表示することができる --}}
                            {{-- $category->name でprimaryCategoryを表示してる --}}
                            {{-- @foreach($category->secondary as $secondary) categoryは、primaryCategoryを表示してる。 --}}
                            {{-- $category->secondary は、primaryからsecondaryに渡してる --}}
                            {{-- PrimaryCategoryモデルよりsecondary関数でSecondCategoryを取得できる
                                //リレーション PrimaryCategory:SecondCategory （1:多）
                                public function secondary()
                                {
                                    return $this->hasMany(SecondaryCategory::class);
                                }
                            --}}
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー</label>
                                    <select name="category" id="category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        @foreach($categories as $category)
                                            <optgroup label="{{ $category->name }}">
                                            @foreach($category->secondary as $secondary)
                                                <option value="{{ $secondary->id}}">
                                                    {{ $secondary->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <x-select-image :images="$images" name="image1" />
                        <x-select-image :images="$images" name="image2" />
                        <x-select-image :images="$images" name="image3" />
                        <x-select-image :images="$images" name="image4" />
                        <x-select-image :images="$images" name="image5" />
                        {{-- 販売中、停止中 --}}
                        <div class="p-2 w-1/2 mx-auto">
                            <div class="relative flex justify-around">
                                <div><input type="radio" name="is_selling" value="1" class="mr-2" checked >販売中</div>
                                <div><input type="radio" name="is_selling" value="0" class="mr-2" >停止中</div>
                            </div>
                        </div>
                        <div class="p-2 w-full flex justify-around mt-4">
                            {{-- 戻るボタン。owner.products.indexブレードに戻る。{{ route('owner.products.index') }}--}}
                            <button type="button" onclick="location.href='{{ route('owner.products.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
'use strict'
const images = document.querySelectorAll('.image') //全てのimageタグを取得
images.forEach(image => { // 1つずつ繰り返す
    image.addEventListener('click', function(e){ // クリックしたら
        const imageName = e.target.dataset.id.substr(0, 6) //data-idの6文字
        const imageId = e.target.dataset.id.replace(imageName + '_', '') // 6文字カット
        const imageFile = e.target.dataset.file
        const imagePath = e.target.dataset.path
        const modal = e.target.dataset.modal

        // サムネイルと input type=hiddenのvalueに設定
        document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile
        document.getElementById(imageName + '_hidden').value = imageId
        MicroModal.close(modal); //モーダルを閉じる
    })
})
</script>
</x-app-layout>
