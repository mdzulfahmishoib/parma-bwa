<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Category') }}
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
                
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
            
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $category->name }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
            
                    <!-- Icon -->
                    <div class="mt-4">
                        <x-input-label for="icon" :value="__('Icon')" class="mb-2"/>
                        <img src="{{ Storage::url($category->icon) }}" class="w-[50px] h-[50px] mb-2">
                        <x-text-input id="icon" class="block mt-1 w-full" type="file" name="icon" autofocus/>
                        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                    </div>
            
                    <div class="flex items-center justify-end mt-4">
            
                        <button type="submit" class="font-bold py-3 px-5 rounded-full text-white bg-indigo-700 text-sm">
                            {{ __('Update Category') }}
                        </button>
                        
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
