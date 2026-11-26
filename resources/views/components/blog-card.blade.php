@props(['post'])

{{-- One blog post card: used on the home page teaser and on /blog. Posts without a cover get a gradient. --}}
<a href="/blog/{{ $post->slug }}"
   {{ $attributes->class(['group flex flex-col bg-white border border-stone-200 rounded-3xl overflow-hidden hover:-translate-y-1 hover:border-violet-300 hover:shadow-xl hover:shadow-violet-500/10 transition-all duration-300']) }}>

    <div class="aspect-[16/9] overflow-hidden relative bg-stone-100">
        @if($post->cover_image)
            <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        @else
            <div class="w-full h-full bg-linear-to-br {{ \App\Support\Gradient::for($post->title) }} relative">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,.35),transparent_55%)]"></div>
            </div>
        @endif

        <span class="absolute bottom-3 right-3 font-mono text-xs px-3 py-1 rounded-full bg-white/90 backdrop-blur text-stone-800">
            {{ $post->read_time_minutes }} min read
        </span>
    </div>

    <div class="p-5 flex flex-col flex-1">
        <div class="flex items-center gap-2 mb-3 flex-wrap">
            @foreach(array_slice($post->tags ?? [], 0, 2) as $tag)
                <span class="text-xs px-2.5 py-1 bg-violet-100 text-violet-700 rounded-full">{{ $tag }}</span>
            @endforeach
        </div>

        <h3 class="font-serif text-2xl leading-[1.1] text-stone-900 group-hover:text-violet-700 transition-colors">{{ $post->title }}</h3>

        @if($post->excerpt)
            <p class="text-sm md:text-[15px] text-stone-600 mt-2 line-clamp-3 leading-relaxed">{{ $post->excerpt }}</p>
        @endif

        <p class="font-mono text-xs text-stone-400 mt-auto pt-4">{{ $post->published_at?->format('M j, Y') }}</p>
    </div>
</a>
