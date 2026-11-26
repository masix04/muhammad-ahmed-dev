<div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6 mb-10">
        @forelse($posts as $post)
            <x-blog-card :post="$post" wire:key="post-{{ $post->id }}" />
        @empty
            <div class="col-span-full py-14 text-center rounded-3xl border border-dashed border-stone-300">
                <p class="font-serif text-2xl text-stone-400">No posts yet</p>
                <p class="text-stone-400 mt-1 text-sm">Check back soon.</p>
            </div>
        @endforelse
    </div>

    @if($posts->isNotEmpty())
        <a href="/blog" class="group inline-flex items-center gap-3 min-h-11 text-sm font-medium text-stone-900 hover:text-violet-700 transition-colors">
            All posts
            <span class="w-9 h-9 rounded-full border border-stone-300 flex items-center justify-center group-hover:bg-violet-600 group-hover:border-violet-600 group-hover:text-white transition-all" aria-hidden="true">→</span>
        </a>
    @endif
</div>
