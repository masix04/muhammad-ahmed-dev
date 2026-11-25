<x-layouts.app title="Dev Notes — Muhammad Ahmed">

    <section class="max-w-6xl mx-auto px-6 pt-32 pb-12">
        <div class="mb-12">
            <p class="text-xs tracking-widest text-stone-400 uppercase mb-2">Writing</p>
            <h1 class="font-serif text-5xl text-stone-900">Dev Notes</h1>
            <p class="mt-3 text-stone-400 font-light">Things I've learned, built, or debugged.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
            @forelse($posts as $post)
                <a href="/blog/{{ $post->slug }}"
                   class="group block bg-white border border-stone-200 rounded-2xl overflow-hidden hover:border-stone-300 hover:shadow-sm transition-all">
                    @if($post->cover_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            @foreach(array_slice($post->tags ?? [], 0, 2) as $tag)
                                <span class="text-xs px-2 py-0.5 bg-stone-100 text-stone-500 rounded-full">{{ $tag }}</span>
                            @endforeach
                            <span class="text-xs text-stone-300 ml-auto">{{ $post->read_time_minutes }} min read</span>
                        </div>
                        <h2 class="font-medium text-stone-900 leading-snug text-sm group-hover:text-stone-600 transition-colors">{{ $post->title }}</h2>
                        @if($post->excerpt)
                            <p class="text-xs text-stone-400 font-light mt-2 line-clamp-2 leading-relaxed">{{ $post->excerpt }}</p>
                        @endif
                        <p class="text-xs text-stone-300 mt-3">{{ $post->published_at?->format('M j, Y') }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center">
                    <p class="text-stone-400 text-sm">No posts yet — check back soon.</p>
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="flex items-center justify-between text-sm">
                @if($posts->onFirstPage())
                    <span class="text-stone-300">← Newer</span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="text-stone-500 hover:text-stone-900 transition-colors">← Newer</a>
                @endif

                <span class="text-xs text-stone-400">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span>

                @if($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="text-stone-500 hover:text-stone-900 transition-colors">Older →</a>
                @else
                    <span class="text-stone-300">Older →</span>
                @endif
            </div>
        @endif
    </section>

</x-layouts.app>
