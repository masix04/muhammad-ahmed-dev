<div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        @forelse($posts as $post)
        <a href="/blog/{{ $post->slug }}" class="group block bg-white border border-stone-200 rounded-2xl overflow-hidden hover:border-stone-300 hover:shadow-sm transition-all">
            @if($post->cover_image)
            <div class="aspect-video overflow-hidden">
                <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}"
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
                <h3 class="font-medium text-stone-900 leading-snug text-sm group-hover:text-stone-600 transition-colors">{{ $post->title }}</h3>
                @if($post->excerpt)
                <p class="text-xs text-stone-400 font-light mt-2 line-clamp-2 leading-relaxed">{{ $post->excerpt }}</p>
                @endif
                <p class="text-xs text-stone-300 mt-3">{{ $post->published_at?->diffForHumans() }}</p>
            </div>
        </a>
        @empty
        <div class="col-span-3 py-16 text-center">
            <p class="text-stone-400 text-sm">No posts yet — check back soon.</p>
        </div>
        @endforelse
    </div>
    @if($posts->isNotEmpty())
    <div class="text-center">
        <a href="/blog" class="inline-flex items-center gap-2 text-sm text-stone-500 hover:text-stone-900 transition-colors">
            All posts
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
    @endif
</div>
