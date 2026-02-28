@props(['article'])

<div class="group relative flex flex-col bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:border-gray-200 transition-all duration-300 hover:-translate-y-1">

    {{-- Image Area --}}
    <div class="relative overflow-hidden bg-gray-50 h-48">
        @if ($article->image_url)
            <img
                class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                src="{{ $article->image_url }}"
                alt="{{ $article->ab_name }}"
            >
        @else
            <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-xs font-medium tracking-wide uppercase">Kein Bild</span>
            </div>
        @endif

        {{-- Price Badge --}}
        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-gray-900 font-bold text-sm px-3 py-1 rounded-full shadow-sm border border-gray-100">
            {{ number_format($article->ab_price, 2, ',', '.') }} €
        </div>
    </div>

    {{-- Content --}}
    <div class="flex flex-col flex-1 p-4 gap-3">

        <div class="flex-1">
            <h5 class="font-semibold text-gray-900 truncate text-base leading-snug">
                {{ $article->ab_name }}
            </h5>
            <p class="mt-1 text-sm text-gray-500 line-clamp-2 leading-relaxed">
                {{ $article->ab_description }}
            </p>
        </div>

        {{-- Seller --}}
        <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
            <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs shrink-0">
                {{ strtoupper(substr($article->abuser->ab_name, 0, 1)) }}
            </div>
            <span class="text-xs text-gray-400 truncate">{{ $article->abuser->ab_name }}</span>
        </div>

        {{-- CTA Button --}}
        <button
            onclick="cartload({{ $article->id }})"
            class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-semibold py-2.5 rounded-xl transition-all duration-150 cursor-pointer"
        >
            <span>In den Warenkorb</span>
            <span>🛒</span>
        </button>

    </div>
</div>
