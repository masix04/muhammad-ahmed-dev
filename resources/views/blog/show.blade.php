<x-layouts.app :title="$post->title . ' — Muhammad Ahmed'" :description="$post->excerpt ?: null" type="article" :hero-dark="true">

    @push('head')
        @if($post->published_at)
            <meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
        @endif
    @endpush

    {{-- Dark masthead with the post title --}}
    <header class="relative bg-stone-950 text-white overflow-hidden">
        <div class="absolute -top-32 right-0 w-[420px] md:w-[520px] h-[420px] md:h-[520px] bg-violet-600/30 blur-[130px] md:blur-[150px] rounded-full pointer-events-none"></div>
        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 pt-28 md:pt-32 pb-10 md:pb-14">
            <a href="/blog" class="inline-flex items-center min-h-11 gap-2 text-sm text-stone-400 hover:text-white transition-colors mb-4">
                ← All posts
            </a>

            <div class="flex items-center gap-2 mb-5 flex-wrap">
                @foreach($post->tags ?? [] as $tag)
                    <span class="text-xs px-3 py-1 bg-violet-400/15 border border-violet-400/30 text-violet-200 rounded-full">{{ $tag }}</span>
                @endforeach
            </div>

            <h1 class="font-serif text-4xl md:text-5xl leading-[1.05] tracking-tight">{{ $post->title }}</h1>

            <p class="mt-6 font-mono text-xs tracking-wider text-stone-400">
                {{ $post->published_at?->format('F j, Y') }} · {{ $post->read_time_minutes }} min read
            </p>
        </div>
    </header>

    <article class="max-w-3xl mx-auto px-4 sm:px-6 py-10 md:py-16">
        @if($post->cover_image)
            <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}"
                 class="w-full rounded-3xl mb-10 aspect-video object-cover shadow-xl shadow-stone-900/10">
        @endif

        {{-- Body is HTML written by the site owner in the Filament rich editor. --}}
        <div class="post-body">{!! $post->body !!}</div>
    </article>

</x-layouts.app>
