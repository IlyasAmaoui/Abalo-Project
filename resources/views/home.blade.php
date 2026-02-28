<x-layout>
    <x-slot:title>
        Home Feed
    </x-slot:title>

     <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($articles as $article)
            <x-article :article="$article" />
        @empty
            <div class="hero py-12">
                <div class="hero-content text-center">
                    <div>
                        <svg class="mx-auto h-12 w-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="mt-4 text-base-content/60">No articles yet. Be the first to sell!</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    <div class="">
        {{ $articles->appends(request()->query())->links() }}
    </div>

</x-layout>
