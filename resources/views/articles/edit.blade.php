<x-layout>


        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
                <a href="{{ route('home') }}"
                   class="hover:text-indigo-600 transition-colors">
                    Home
                </a>

                <span>/</span>

                <a href="{{ route('abArticles.show', $abarticle) }}"
                   class="hover:text-indigo-600 transition-colors truncate">
                    {{ $abarticle->ab_name }}
                </a>

                <span>/</span>

                <span class="text-gray-600 font-medium">
                Edit
            </span>
            </nav>


            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                    Artikel bearbeiten
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Bearbeite die Informationen deines Artikels.
                </p>
            </div>


            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100">
                    <p class="text-sm font-semibold text-red-700 mb-2">
                        Bitte überprüfe deine Eingaben:
                    </p>

                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Edit Form --}}
            <form
                action="{{ route('abArticles.update', $abarticle) }}"
                method="POST"
                enctype="multipart/form-data"
                class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8"
            >

                @csrf
                @method('PUT')


                {{-- Article Name --}}
                <div class="mb-6">
                    <label
                        for="ab_name"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Artikelname
                    </label>

                    <input
                        type="text"
                        id="ab_name"
                        name="ab_name"
                        value="{{ old('ab_name', $abarticle->ab_name) }}"
                        maxlength="80"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                           text-sm text-gray-900
                           focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500
                           transition"
                        placeholder="z.B. Vintage Nike Jacke"
                    >

                    @error('ab_name')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                    @enderror
                </div>


                {{-- Price --}}
                <div class="mb-6">
                    <label
                        for="ab_price"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Preis
                    </label>

                    <div class="relative">
                        <input
                            type="number"
                            id="ab_price"
                            name="ab_price"
                            value="{{ old('ab_price', $abarticle->ab_price) }}"
                            min="0"
                            step="1"
                            required
                            class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-200
                               text-sm text-gray-900
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               focus:border-indigo-500
                               transition"
                            placeholder="0"
                        >

                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                        €
                    </span>
                    </div>

                    @error('ab_price')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                    @enderror
                </div>


                {{-- Description --}}
                <div class="mb-6">
                    <label
                        for="ab_description"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Beschreibung
                    </label>

                    <textarea
                        id="ab_description"
                        name="ab_description"
                        rows="7"
                        maxlength="1000"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                           text-sm text-gray-900 resize-none
                           focus:outline-none focus:ring-2 focus:ring-indigo-500
                           focus:border-indigo-500
                           transition"
                        placeholder="Beschreibe deinen Artikel..."
                    >{{ old('ab_description', $abarticle->ab_description) }}</textarea>

                    @error('ab_description')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                    @enderror
                </div>


                {{-- Current Image --}}
                @if ($abarticle->image_url)
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Aktuelles Bild
                        </label>

                        <div class="w-full h-64 bg-gray-50 rounded-xl border border-gray-100 overflow-hidden">
                            <img
                                src="{{ $abarticle->image_url }}"
                                alt="{{ $abarticle->ab_name }}"
                                class="w-full h-full object-contain p-6"
                            >
                        </div>
                    </div>
                @endif


                {{-- New Image --}}
                <div class="mb-8">
                    <label
                        for="image"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Neues Bild
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200
                           text-sm text-gray-600
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:text-sm file:font-semibold
                           file:bg-indigo-50 file:text-indigo-600
                           hover:file:bg-indigo-100
                           transition"
                    >

                    <p class="mt-2 text-xs text-gray-400">
                        Optional. Lade ein neues Bild hoch, um das aktuelle Bild zu ersetzen.
                    </p>

                    @error('image')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                    @enderror
                </div>


                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">

                    <a
                        href="{{ route('abArticles.show', $abarticle) }}"
                        class="inline-flex items-center justify-center
                           px-5 py-3 rounded-xl
                           border border-gray-200
                           text-sm font-semibold text-gray-600
                           hover:bg-gray-50
                           transition-colors"
                    >
                        Abbrechen
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center
                           px-5 py-3 rounded-xl
                           bg-indigo-600 hover:bg-indigo-700
                           text-white text-sm font-semibold
                           transition-colors cursor-pointer"
                    >
                        Änderungen speichern
                    </button>

                </div>

            </form>

        </div>

    </x-layout>

