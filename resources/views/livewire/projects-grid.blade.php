@php
    use App\Support\Gradient;
    use App\Support\TechnologyColors;
@endphp

<div>
    {{-- Tag filter: one scrolling row on phones, wrapping chips from "sm" up --}}
    <div class="flex gap-2 mb-8 overflow-x-auto sm:flex-wrap sm:overflow-visible -mx-4 px-4 sm:mx-0 sm:px-0 pb-2 sm:pb-0 snap-x" role="group" aria-label="Filter projects by technology">

        @foreach($allTags as $tag)
            <button
                type="button"
                wire:click="filterBy(@js($tag))"
                aria-pressed="{{ $activeTag === $tag ? 'true' : 'false' }}"
                class="shrink-0 snap-start h-10 px-3.5 rounded-full text-[13px] border transition-all cursor-pointer hover:-translate-y-0.5

                {{ $activeTag === $tag
                    ? 'ring-2 ring-offset-2 ring-stone-900 font-medium'
                    : ''
                }}

                {{ $tag === 'All'
                    ? TechnologyColors::light('All')
                    : TechnologyColors::light(
                        config("skill-categories.technologies.$tag", 'All')
                    )
                }}"
            >
                {{ $tag }}
            </button>
        @endforeach

    </div>

    {{-- Grid --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
        @forelse($projects as $project)

            <article
                wire:key="project-{{ $project->id }}"
                wire:click="openModal({{ $project->id }})"
                wire:keydown.enter="openModal({{ $project->id }})"
                tabindex="0"
                role="button"
                aria-label="View details: {{ $project->title }}"
                style="--i: {{ $loop->index }}"
                class="card-in group cursor-pointer flex flex-col bg-white border border-stone-200 rounded-3xl overflow-hidden
                    hover:-translate-y-1 hover:border-violet-300 hover:shadow-xl hover:shadow-violet-500/10
                    focus-visible:outline-2 focus-visible:outline-violet-500 transition-all duration-300"
            >
                {{-- Thumbnail --}}
                <div class="aspect-[16/10] overflow-hidden relative bg-stone-100">

                    @if($project->thumbnail)
                        <img
                            src="{{ Storage::url($project->thumbnail) }}"
                            alt="{{ $project->title }}"
                            loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        >
                    @else
                        {{-- No image: a gradient of its own, with the initials as a watermark --}}
                        <div class="w-full h-full bg-linear-to-br {{ Gradient::for($project->title) }} relative flex items-end p-4">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,.35),transparent_55%)]"></div>
                            <span class="relative font-serif text-6xl leading-none text-white/90 mix-blend-overlay group-hover:scale-110 origin-bottom-left transition-transform duration-700">
                                {{ Gradient::initials($project->title) }}
                            </span>
                        </div>
                    @endif

                    @if($project->category)
                        <span class="absolute top-3 left-3 font-mono text-xs px-3 py-1 rounded-full bg-white/90 backdrop-blur text-stone-800">
                            {{ $project->category }}
                        </span>
                    @endif

                    @if($project->is_featured)
                        <span class="absolute top-3 right-3 text-xs font-medium px-2.5 py-1 rounded-full bg-amber-300 text-amber-950">
                            ★ Featured
                        </span>
                    @endif

                    @if($project->demo_video_url)
                        <div class="absolute bottom-3 right-3 w-10 h-10 rounded-full bg-black/60 backdrop-blur flex items-center justify-center group-hover:bg-violet-600 transition-colors" title="Has a demo video">
                            <svg class="w-4 h-4 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    @endif

                </div>

                {{-- Body --}}
                <div class="p-5 flex flex-col flex-1">

                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="font-serif text-2xl leading-[1.1] text-stone-900 group-hover:text-violet-700 transition-colors">
                            {{ $project->title }}
                        </h3>

                        <span class="shrink-0 mt-0.5 w-8 h-8 rounded-full border border-stone-200 flex items-center justify-center text-sm text-stone-400 group-hover:bg-violet-600 group-hover:border-violet-600 group-hover:text-white group-hover:rotate-45 transition-all duration-300" aria-hidden="true">
                            →
                        </span>
                    </div>

                    <p class="text-sm md:text-[15px] text-stone-600 leading-relaxed mb-4 line-clamp-3">
                        {{ $project->short_description }}
                    </p>

                    <div class="flex flex-wrap gap-1.5 mt-auto">
                        @foreach(array_slice($project->tech_tags ?? [], 0, 4) as $tag)
                            <span
                                class="text-xs px-2.5 py-1 rounded-full
                                {{ TechnologyColors::badge($tag) }}"
                            >
                                {{ $tag }}
                            </span>
                        @endforeach

                        {{-- "more" badge --}}
                        @if(count($project->tech_tags ?? []) > 4)
                            <span class="text-xs px-2.5 py-1 rounded-full bg-stone-100 text-stone-500">
                                +{{ count($project->tech_tags) - 4 }}
                            </span>
                        @endif
                    </div>

                </div>
            </article>
        @empty
        <div class="col-span-full py-16 text-center">
            <p class="text-stone-400">No projects found for <strong class="text-stone-600">{{ $activeTag }}</strong>.</p>
        </div>
        @endforelse
    </div>

    {{-- ── PROJECT MODAL: full-screen sheet on phones, centred card from "sm" up ─── --}}
    @if($openProject)
    {{-- Only add this overflowhidden when model is open --}}
    @php
        echo '<script>document.body.classList.add("overflow-hidden")</script>';
    @endphp
    <div
        x-data
        x-trap="true"
        x-init="$nextTick(() => document.body.classList.add('overflow-hidden'))"
        x-destroy="document.body.classList.remove('overflow-hidden')"
        @keydown.escape.window="$wire.closeModal()"
        role="dialog"
        aria-modal="true"
        aria-labelledby="project-modal-title"
        class="fixed inset-0 z-[60] flex items-stretch sm:items-start justify-center sm:p-6 md:p-10 bg-stone-950/70 backdrop-blur-md overflow-y-auto overscroll-contain"
        wire:click.self="closeModal"
    >
        <div
            class="relative w-full max-w-3xl bg-white sm:rounded-[1.75rem] shadow-2xl shadow-black/40 overflow-hidden sm:my-auto"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-6 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        >
            {{-- Close --}}
            <button
                type="button"
                wire:click="closeModal"
                aria-label="Close project details"
                class="absolute top-3 right-3 z-10 w-11 h-11 flex items-center justify-center bg-white/90 backdrop-blur rounded-full border border-stone-200 text-stone-600 hover:bg-stone-950 hover:text-white hover:border-stone-950 transition-colors"
            >✕</button>

            {{-- Media --}}
            @if($openProject->demo_video_url)
            <div class="aspect-video w-full bg-stone-900">
                <iframe
                    src="{{ $openProject->youtube_embed }}"
                    title="{{ $openProject->title }} demo video"
                    loading="lazy"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                ></iframe>
            </div>
            @elseif($openProject->thumbnail)
            <div class="aspect-video w-full overflow-hidden">
                <img src="{{ Storage::url($openProject->thumbnail) }}" alt="{{ $openProject->title }}" loading="lazy" class="w-full h-full object-cover">
            </div>
            @else
            {{-- No image: the same gradient the card uses --}}
            <div class="h-28 sm:h-40 w-full bg-linear-to-br {{ Gradient::for($openProject->title) }} relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_25%_20%,rgba(255,255,255,.4),transparent_55%)]"></div>
                <span class="absolute -bottom-4 left-6 font-serif text-8xl sm:text-9xl leading-none text-white/80 mix-blend-overlay select-none" aria-hidden="true">
                    {{ Gradient::initials($openProject->title) }}
                </span>
            </div>
            @endif

            {{-- Content --}}
            <div class="p-5 sm:p-8 md:p-10">
                <div class="flex items-start justify-between gap-5 mb-7 flex-wrap">
                    <div class="min-w-0">
                        @if($openProject->category)
                            <span class="font-mono text-xs text-violet-600 uppercase tracking-[.2em]">{{ $openProject->category }}</span>
                        @endif
                        <h2 id="project-modal-title" class="font-serif text-3xl md:text-4xl text-stone-900 mt-1.5 leading-[1.05] tracking-tight">{{ $openProject->title }}</h2>
                        @if($openProject->my_role)
                            <p class="text-sm text-stone-400 mt-3">My role: <span class="text-stone-700 font-medium">{{ $openProject->my_role }}</span></p>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        @if($openProject->github_url)
                            <a href="{{ $openProject->github_url }}" target="_blank" rel="noopener"
                                class="inline-flex items-center gap-2 h-11 px-5 text-sm border border-stone-300 rounded-full hover:bg-stone-950 hover:text-white hover:border-stone-950 transition-colors text-stone-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12"/></svg>
                                Code
                            </a>
                        @endif
                        @if($openProject->live_url)
                            <a href="{{ $openProject->live_url }}" target="_blank" rel="noopener"
                                class="inline-flex items-center gap-2 h-11 px-5 text-sm bg-linear-to-r from-violet-600 to-fuchsia-500 text-white rounded-full shadow-lg shadow-violet-600/25 hover:-translate-y-0.5 transition-all">
                                Live site ↗
                            </a>
                        @endif
                    </div>
                </div>

                @php
                    $caseStudy = array_filter([
                        'The problem'  => $openProject->challenge,
                        'What I built' => $openProject->solution,
                        'The result'   => $openProject->outcome,
                    ]);
                    // Written out in full so Tailwind can find the classes.
                    $caseColumns = [2 => 'md:grid-cols-2', 3 => 'md:grid-cols-3'][count($caseStudy)] ?? '';
                @endphp
                @if($caseStudy)
                    <dl class="mb-8 grid gap-3 {{ $caseColumns }}">
                        @foreach($caseStudy as $label => $text)
                            <div class="rounded-2xl bg-stone-50 border border-stone-200 p-4">
                                <dt class="font-mono text-xs uppercase tracking-[.2em] text-violet-600 mb-2">{{ $label }}</dt>
                                <dd class="text-sm md:text-[15px] text-stone-700 leading-relaxed whitespace-pre-line">{{ $text }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif

                <div class="post-body !text-base mb-7">
                    {!! $openProject->full_description ?? '<p>' . e($openProject->short_description) . '</p>' !!}
                </div>

                @if($openProject->tech_tags)
                <div class="flex flex-wrap gap-2 pt-5 border-t border-stone-200">
                    @foreach($openProject->tech_tags as $tag)
                    <span class="text-xs px-3 py-1.5 bg-violet-100 text-violet-700 rounded-full font-medium">{{ $tag }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
