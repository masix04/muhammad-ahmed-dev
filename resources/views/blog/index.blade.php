<x-layouts.app title="Dev Notes — Muhammad Ahmed" :hero-dark="true">

    {{-- Dark masthead, like the home page hero --}}
    <header class="relative bg-stone-950 text-white overflow-hidden">
        <div class="absolute -top-32 right-0 w-[420px] md:w-[520px] h-[420px] md:h-[520px] bg-violet-600/30 blur-[130px] md:blur-[150px] rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-40 left-0 w-[360px] md:w-[420px] h-[360px] md:h-[420px] bg-emerald-400/15 blur-[130px] md:blur-[150px] rounded-full pointer-events-none"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 pt-32 md:pt-36 pb-12 md:pb-16">
            <p class="font-mono text-xs tracking-[.25em] uppercase text-violet-300 mb-3">Writing</p>
            <h1 class="font-serif text-5xl md:text-7xl leading-[.95] tracking-tight">Dev <em class="text-gradient pr-2">Notes</em></h1>
            <p class="mt-4 text-base md:text-lg text-stone-400 font-light max-w-xl">Things I've learned, built, or debugged.</p>
        </div>
    </header>

    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-12 md:py-20">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6 mb-12">
            @forelse($posts as $post)
                <x-blog-card :post="$post" />
            @empty
                <div class="col-span-full py-16 text-center rounded-3xl border border-dashed border-stone-300">
                    <p class="font-serif text-3xl text-stone-400">No posts yet</p>
                    <p class="text-stone-400 mt-1 text-sm">Check back soon.</p>
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="flex items-center justify-between text-sm">
                @if($posts->onFirstPage())
                    <span class="text-stone-300">← Newer</span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="inline-flex items-center min-h-11 font-medium text-stone-700 hover:text-violet-700 transition-colors">← Newer</a>
                @endif

                <span class="font-mono text-xs text-stone-400">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span>

                @if($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="inline-flex items-center min-h-11 font-medium text-stone-700 hover:text-violet-700 transition-colors">Older →</a>
                @else
                    <span class="text-stone-300">Older →</span>
                @endif
            </div>
        @endif
    </section>

</x-layouts.app>
