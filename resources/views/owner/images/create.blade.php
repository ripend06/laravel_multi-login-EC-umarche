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
                    {{-- 画像がある場合は、enctype属性が必要。 enctype="multipart/form-data" --}}
                    {{-- actionでstoreに渡す。⭐sotreの場合は、updateと違って、パラメータ不要 {{ route('owner.images.store') }} --}}
                    {{-- バリデーションを作成 --}}
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="post" action="{{ route('owner.images.store') }}" enctype="multipart/form-data">
                    @csrf
                        <div class="-m-2">
                            {{-- 画像アップロード --}}
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="image" class="leading-7 text-sm text-gray-600">画像</label>
                                    {{-- ファイルタイプを制限 accept accept="image/png,image/jpeg,image/jpg" --}}
                                    {{-- multiple属性で、複数対応可能 --}}
                                    <input type="file" id="image" name="files[][image]" multiple accept="image/png,image/jpeg,image/jpg" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                        </div>
                        <div class="p-2 w-full flex justify-around mt-4">
                            {{-- 戻るボタン。owner.shop.indexブレードに戻る。{{ route('owner.shops.index') }}--}}
                            <button type="button" onclick="location.href='{{ route('owner.images.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>