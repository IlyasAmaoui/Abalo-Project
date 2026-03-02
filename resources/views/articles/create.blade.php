<x-layout>
    <x-slot:title>
       Create an article
    </x-slot:title>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="max-w-2xl mx-auto mb-8">
            <a href="" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to articles
            </a>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Sell an Article</h1>
            <p class="mt-1 text-gray-500 text-sm">Fill in the details below to list your article on the marketplace.</p>
        </div>

        {{-- Form Card --}}
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form action="/articles" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                @csrf

                {{-- Name --}}
                <div class="flex flex-col gap-1.5">
                    <label for="name" class="text-sm font-medium text-gray-700">
                        Article Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. Vintage Leather Jacket"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('name') border-red-400 bg-red-50 @enderror"

                    >
                    @error('name')
                    <p class="text-xs text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="flex flex-col gap-1.5">
                    <label for="description" class="text-sm font-medium text-gray-700">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Describe your article — condition, size, details..."
                        maxlength="255"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none @error('description') border-red-400 bg-red-50 @enderror"
                    >{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-xs text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Price --}}
                <div class="flex flex-col gap-1.5">
                    <label for="price" class="text-sm font-medium text-gray-700">
                        Price (€) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">€</span>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price') }}"
                            placeholder="0.00"
                            min="0"
                            step="0.01"
                            class="w-full rounded-xl border border-gray-200 pl-8 pr-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('price') border-red-400 bg-red-50 @enderror"
                        >
                    </div>
                    @error('price')
                    <p class="text-xs text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Image Upload --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-gray-700">Image</label>
                    <label
                        for="image"
                        class="group relative flex flex-col items-center justify-center gap-3 w-full h-40 rounded-xl border-2 border-dashed border-gray-200 hover:border-indigo-400 hover:bg-indigo-50/50 transition cursor-pointer @error('image') border-red-400 bg-red-50 @enderror"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300 group-hover:text-indigo-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div class="text-center">
                            <span class="text-sm text-indigo-600 font-medium">Click to upload</span>
                            <span class="text-sm text-gray-400"> or drag and drop</span>
                            <p class="text-xs text-gray-400 mt-0.5">JPG, PNG up to 5MB</p>
                        </div>
                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/jpeg,image/png,image/jpg"
                            class="hidden"
                        >
                    </label>
                    {{-- Preview --}}
                    <div id="image-preview" class="hidden mt-2">
                        <img id="preview-img" src="" alt="Preview" class="w-full h-48 object-contain rounded-xl border border-gray-100 bg-gray-50 p-2">
                    </div>
                    @error('image')
                    <p class="text-xs text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="/articles" class="text-sm text-gray-500 hover:text-gray-700 transition">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-all duration-150 cursor-pointer"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        List Article
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        document.getElementById('image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) { return; }

            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');

            const reader = new FileReader();
            reader.onload = (e) => {
                img.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-layout>
