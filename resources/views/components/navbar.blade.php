@props(['cartCount' => 0])

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a  href="{{ Route::has('home') ? route('home') : '/' }}" class="flex items-center gap-2 shrink-0 no-underline">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-8 h-8 fill-gray-900">
                    <path d="M16 2L28 14L16 20L4 14L16 2Z" />
                    <path d="M16 30L4 18L16 24L28 18L16 30Z" />
                </svg>
                <span class=" text-lg text-gray-900 tracking-tight"> Abalo-Marketplace</span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-1">
                <div class="relative group">
                    <button class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                        <span>Shop</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div class="absolute left-0 top-full pt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-2">
                            <a href="{{ Route::has('products.index') ? route('products.index') : '#' }}" class="block px-3 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-xl transition-colors">
                                Alle Artikel
                            </a>
                            <a href="{{ Route::has('products.index') ? route('products.index', ['sort' => 'new']) : '#' }}" class="block px-3 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-xl transition-colors">
                                Neu eingetroffen
                            </a>
                            <a href="{{ Route::has('products.index') ? route('products.index', ['sort' => 'popular']) : '#' }}" class="block px-3 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-xl transition-colors">
                                Beliebt
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Right actions --}}
            <div class="flex items-center gap-4">

                {{-- Language --}}
                <div class="relative group hidden sm:block">
                    <button class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                        <span>DE</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="absolute right-0 top-full pt-2 w-32 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-2">
                            <button class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-xl transition-colors cursor-pointer">Deutsch</button>
                            <button class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-xl transition-colors cursor-pointer">English</button>
                        </div>
                    </div>
                </div>

                {{-- Search --}}
                <button
                    type="button"
                    onclick="toggleSearch()"
                    class="w-10 h-10 flex items-center justify-center text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-lg transition-colors cursor-pointer"
                    aria-label="Suche"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                </button>


                {{-- Cart --}}
                {{-- TODO: Cart noch nicht implementiert. Route::has() verhindert einen Crash,
                     bis 'cart.index' registriert ist. --}}
                <a
                    href="{{ Route::has('cart.index') ? route('cart.index') : '#' }}"
                    class="relative w-10 h-10 flex items-center justify-center  text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-lg transition-colors"
                    aria-label="Warenkorb"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l3.6-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 0a2 2 0 104 0m6 0a2 2 0 104 0" />
                    </svg>

                    @if ($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-[10px] font-bold w-4.5 h-4.5 min-w-[18px] px-1 rounded-full flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- Account --}}
                <div class="navbar-end gap-3">
                    @auth
                        <a href="/newarticle" class=" btn btn-ghost btn-sm"> Create new Article</a>
                        <span class="text-sm">{{ auth()->user()->ab_name }}</span>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
                        </form>
                    @else
                        <a href="/login" class="btn btn-ghost btn-sm">Sign In</a>
                        <a href="/register" class="btn btn-primary btn-sm">Sign Up</a>
                    @endauth
                </div>

                {{-- Mobile menu toggle --}}
                <button
                    type="button"
                    onclick="toggleMobileMenu()"
                    class="md:hidden w-10 h-10 flex items-center justify-center text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-lg transition-colors cursor-pointer"
                    aria-label="Menü"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu panel --}}
        <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-100 pt-3">
            <a href="{{ Route::has('products.index') ? route('products.index') : '#' }}" class="block px-2 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg hover:bg-gray-50 transition-colors">
                Alle Artikel
            </a>
            <a href="{{ Route::has('products.index') ? route('products.index', ['sort' => 'new']) : '#' }}" class="block px-2 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg hover:bg-gray-50 transition-colors">
                Neu eingetroffen
            </a>
            <a href="{{ Route::has('products.index') ? route('products.index', ['sort' => 'popular']) : '#' }}" class="block px-2 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-lg hover:bg-gray-50 transition-colors">
                Beliebt
            </a>
        </div>

        {{-- Search overlay --}}
        <div id="search-bar" class="hidden pb-4">
            <form action="{{ Route::has('products.index') ? route('products.index') : '#' }}" method="GET" class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
                <input
                    type="text"
                    name="search"
                    placeholder="Artikel suchen…"
                    class="w-full bg-transparent text-sm text-gray-900 placeholder-gray-400 focus:outline-none"
                >
            </form>
        </div>
    </div>
</header>

<script>
    function toggleMobileMenu() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    }
    function toggleSearch() {
        document.getElementById('search-bar').classList.toggle('hidden');
    }
</script>
