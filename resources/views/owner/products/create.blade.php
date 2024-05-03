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
                                    <select name="category">
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
</x-app-layout>
