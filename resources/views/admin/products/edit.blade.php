<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-10 overflow-hidden shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="py-3 w-full rounded-2xl bg-red-500 text-white">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                
                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
            
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $product->name }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Price -->
                    <div class="mt-4">
                        <x-input-label for="price" :value="__('Price')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ $product->price }}" required autofocus autocomplete="price" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        
                            <select name="category_id" id="category_id" class="py-2 rounded-lg pl-3 w-full border border-slate-300">
                                <option value="{{ $product->category->id }}">{{ $product->category->name }}</option>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @empty
                                    
                                @endforelse
                            </select>

                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    
                    <!-- About -->
                    <div class="mt-4">
                        <x-input-label for="about" :value="__('About')" />
                        <textarea name="about" id="about" cols="20" rows="3" class="py-2 rounded-lg pl-3 w-full border border-slate-300">{{ $product->about }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>
            
                    <!-- Photo -->
                    <div class="mt-4">
                        <x-input-label for="photo" :value="__('Photo')" class="mb-2"/>
                        <img src="{{ Storage::url($product->photo) }}" class="w-[50px] h-[50px] mb-2">
                        <x-text-input id="photo" class="block mt-1 w-full" type="file" name="photo" autofocus/>
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>
            
                    <div class="flex items-center justify-end mt-4 gap-1">

                        <a href="{{ route('admin.products.index') }}" class="font-bold py-3 px-5 rounded-full text-white bg-red-700">Kembali</a>
                        <button type="submit" class="font-bold py-3 px-5 rounded-full text-white bg-indigo-700 text-sm">
                            {{ __('Update Product') }}
                        </button>
                        
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
