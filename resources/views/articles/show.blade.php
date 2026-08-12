<x-layout>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">Home</a>
            <span>/</span>
            <span class="text-gray-600 font-medium truncate">{{ $abarticle->ab_name }}</span>
        </nav>



        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- Image --}}
            <div class="relative bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden h-105 sm:h-125">
                @if ($abarticle->image_url)
                    <img
                        class="w-full h-full object-contain p-8"
                        src="{{ $abarticle->image_url }}"
                        alt="{{ $abarticle->ab_name }}"
                    >
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs font-medium tracking-wide uppercase">Kein Bild</span>
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="flex flex-col gap-6">

                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-snug">
                        {{ $abarticle->ab_name }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-400">
                        Inseriert am {{ $abarticle->ab_createdate->format('d.m.Y') }}
                    </p>
                </div>

                <div class="text-3xl font-bold text-gray-900">
                    {{ number_format($abarticle->ab_price, 2, ',', '.') }} €
                </div>

                <p class="text-sm text-gray-500 leading-relaxed whitespace-pre-line">
                    {{ $abarticle->ab_description }}
                </p>

                {{-- Seller --}}
                <div class="flex items-center gap-3 py-4 border-t border-b border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm shrink-0">
                        {{ strtoupper(substr($abarticle->abuser->ab_name, 0, 1)) }}
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="text-xs text-gray-400">Verkauft von</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $abarticle->abuser->ab_name }}</span>
                    </div>
                </div>



                {{-- Quantity + CTA --}}
                <form action="" method="POST" class="flex items-center gap-3">
                    @csrf

                    <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden shrink-0">
                        <button type="button" onclick="adjustQty(-1)" class="w-10 h-11 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors cursor-pointer">−</button>
                        <input
                            type="number"
                            name="quantity"
                            id="quantity"
                            value="1"
                            min="1"
                            max="10"
                            class="w-12 h-11 text-center text-sm font-semibold text-gray-900 border-x border-gray-200 focus:outline-none"
                        >
                        <button type="button" onclick="adjustQty(1)" class="w-10 h-11 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors cursor-pointer">+</button>
                    </div>

                    <button
                        type="submit"
                        class="flex-1 flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-semibold py-3 rounded-xl transition-all duration-150 cursor-pointer"
                    >
                        <span>In den Warenkorb</span>
                        <span>🛒</span>
                    </button>
                </form>

                <!--  Edit and delete Buttons -->
                @if(auth()->check() && auth()->user()==$abarticle->abuser)<!-- if(auth()->check() && auth()->id()=== $chirp->user_id ) -->
                <div class="flex-1 flex items-center justify-center gap-4">
                    <a href="{{route('abArticles.edit',$abarticle)}}" class="btn  btn-primary btn-sm">
                        Edit
                    </a>
                    <form method="POST" action="{{route('abArticles.destroy',$abarticle)}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this article?')"
                                class="btn  btn-primary btn-sm ">
                            Delete
                        </button>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        function adjustQty(delta) {
            const input = document.getElementById('quantity');
            const next = parseInt(input.value || '1', 10) + delta;
            input.value = Math.min(10, Math.max(1, next));
        }
    </script>

</x-layout>
