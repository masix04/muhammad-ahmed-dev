<div>
    {{-- Tag filter --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @foreach($allTags as $tag)
            <button
                wire:click="filterBy(@js($tag))"
                class="px-4 py-1.5 rounded-full text-xs border transition-all cursor-pointer
                {{
                    $activeTag === $tag
                        ? 'bg-stone-900 text-white border-stone-900'
                        : 'bg-white text-stone-600 border-stone-200 hover:border-stone-300'
                }}"
            >
                {{ $tag }}
            </button>
        @endforeach
    </div>

    {{-- Grid --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($projects as $project)

            <article
                wire:click="openModal({{ $project->id }})"
                class="group cursor-pointer bg-white border border-stone-200 rounded-xl overflow-hidden
                    hover:border-violet-300 hover:shadow-sm transition-all duration-200"
            >
                {{-- Thumbnail --}}
                <div class="aspect-video overflow-hidden relative bg-stone-100">

                    @if($project->thumbnail)
                        <img
                            src="{{ Storage::url($project->thumbnail) }}"
                            alt="{{ $project->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-violet-100 to-emerald-50">
                            <span class="font-serif text-3xl text-violet-300">
                                {{ strtoupper(substr($project->title, 0, 2)) }}
                            </span>
                        </div>
                    @endif

                    @if($project->is_featured)
                        <div class="absolute top-2 left-2 text-[10px] px-2 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-amber-700">
                            Featured
                        </div>
                    @endif

                    @if($project->demo_video_url)
                        <div class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/50 backdrop-blur flex items-center justify-center">
                            <svg class="w-3 h-3 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    @endif

                </div>

                {{-- Body --}}
                <div class="p-4">

                    @if($project->category)
                        <p class="text-[10px] uppercase tracking-wide text-violet-600 mb-1">
                            {{ $project->category }}
                        </p>
                    @endif

                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h3 class="text-sm font-medium text-stone-900 leading-snug">
                            {{ $project->title }}
                        </h3>

                        <svg
                            class="w-3.5 h-3.5 text-stone-300 group-hover:text-violet-500 transition-colors flex-shrink-0 mt-0.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                            />
                        </svg>
                    </div>

                    <p class="text-xs text-stone-500 leading-relaxed mb-3">
                        {{ $project->short_description }}
                    </p>

                    <div class="flex flex-wrap gap-1">
                        @foreach(array_slice($project->tech_tags ?? [], 0, 4) as $tag)
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-violet-100 text-violet-700">
                                {{ $tag }}
                            </span>
                        @endforeach

                        @if(count($project->tech_tags ?? []) > 4)
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-stone-100 text-stone-500">
                                +{{ count($project->tech_tags) - 4 }}
                            </span>
                        @endif
                    </div>

                </div>
            </article>
        @empty
        <div class="col-span-3 py-20 text-center">
            <p class="text-stone-400 text-sm">No projects found for <strong class="text-stone-600">{{ $activeTag }}</strong>.</p>
        </div>
        @endforelse
    </div>

    {{-- ── PROJECT MODAL ─────────────────────────────────────────────── --}}
    @if($openProject)
    <div
        x-data
        x-init="$nextTick(() => document.body.classList.add('overflow-hidden'))"
        x-destroy="document.body.classList.remove('overflow-hidden')"
        class="fixed inset-0 z-50 flex items-start justify-center p-4 md:p-8 bg-black/40 backdrop-blur-sm overflow-y-auto"
        wire:click.self="closeModal"
    >
        <div
            class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden my-auto"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
        >
            {{-- Close --}}
            <button
                wire:click="closeModal"
                class="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center bg-white/80 backdrop-blur rounded-full border border-stone-200 text-stone-400 hover:text-stone-800 transition-colors text-sm"
            >✕</button>

            {{-- Media --}}
            @if($openProject->demo_video_url)
            <div class="aspect-video w-full bg-stone-900">
                <iframe
                    src="{{ $openProject->youtube_embed }}"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
            </div>
            @elseif($openProject->thumbnail)
            <div class="aspect-video w-full overflow-hidden">
                <img src="{{ Storage::url($openProject->thumbnail) }}" alt="{{ $openProject->title }}" class="w-full h-full object-cover">
            </div>
            @endif

            {{-- Content --}}
            <div class="p-7 md:p-10">
                <div class="flex items-start justify-between gap-4 mb-5 flex-wrap">
                    <div>
                        @if($openProject->category)
                            <span class="text-xs text-violet-400 uppercase tracking-widest">{{ $openProject->category }}</span>
                        @endif
                        <h2 class="font-serif text-3xl text-violet-900 mt-1 leading-tight">{{ $openProject->title }}</h2>
                    </div>
                    <div class="flex gap-2 flex-shrink-0">
                        @if($openProject->github_url)
                            <a href="{{ $openProject->github_url }}" target="_blank"
                                class="inline-flex items-center gap-1.5 text-xs px-3 py-1.5 border border-stone-200 rounded-full hover:bg-stone-50 transition-colors text-stone-600">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12"/></svg>
                                Code
                            </a>
                        @endif
                        @if($openProject->live_url)
                            <a href="{{ $openProject->live_url }}" target="_blank"
                                class="inline-flex items-center gap-1.5 text-xs px-3 py-1.5 bg-violet-600 text-white rounded-full hover:bg-violet-700 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Live site
                            </a>
                        @endif
                    </div>
                </div>

                <div class="prose prose-stone prose-sm max-w-none mb-6 font-light leading-relaxed">
                    {!! $openProject->full_description ?? '<p>' . e($openProject->short_description) . '</p>' !!}
                </div>

                @if($openProject->tech_tags)
                <div class="flex flex-wrap gap-2 pt-4 border-t border-stone-100">
                    @foreach($openProject->tech_tags as $tag)
                    <span class="text-xs px-3 py-1 bg-violet-100 text-violet-600 rounded-full font-medium">{{ $tag }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
    
</div>