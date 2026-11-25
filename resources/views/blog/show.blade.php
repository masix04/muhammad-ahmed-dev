<x-layouts.app :title="$post->title . ' — Muhammad Ahmed'" :description="$post->excerpt">

    <article class="max-w-3xl mx-auto px-6 pt-32 pb-12">
        <a href="/blog" class="inline-flex items-center gap-1 text-sm text-stone-400 hover:text-stone-900 transition-colors mb-8">
            ← All posts
        </a>

        <header class="mb-10">
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                @foreach($post->tags ?? [] as $tag)
                    <span class="text-xs px-2 py-0.5 bg-stone-100 text-stone-500 rounded-full">{{ $tag }}</span>
                @endforeach
            </div>
            <h1 class="font-serif text-4xl md:text-5xl leading-tight text-stone-900">{{ $post->title }}</h1>
            <p class="mt-4 text-sm text-stone-400">
                {{ $post->published_at?->format('F j, Y') }} · {{ $post->read_time_minutes }} min read
            </p>
        </header>

        @if($post->cover_image)
            <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}"
                 class="w-full rounded-2xl mb-10 aspect-video object-cover">
        @endif

        {{-- Body is HTML written by the site owner in the Filament rich editor. --}}
        <div class="post-body">{!! $post->body !!}</div>
    </article>

</x-layouts.app>
