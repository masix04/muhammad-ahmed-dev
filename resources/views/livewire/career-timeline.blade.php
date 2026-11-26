@php
    use App\Support\TechnologyColors;
@endphp

{{-- Dark section: a glowing timeline of roles --}}
<div class="relative pl-8 md:pl-12">
    <div class="absolute left-[9px] md:left-[15px] top-2 bottom-2 w-px bg-linear-to-b from-violet-400 via-white/20 to-transparent"></div>

    @foreach($experiences as $exp)
        <div class="relative mb-10 last:mb-0" wire:key="exp-{{ $exp->id }}">

            {{-- Timeline Dot --}}
            <button
                type="button"
                wire:click="toggle({{ $exp->id }})"
                tabindex="-1"
                aria-hidden="true"
                class="absolute -left-8 md:-left-12 top-0.5 max-md:pointer-events-none w-[19px] h-[19px] md:w-[31px] md:h-[31px] rounded-full border-4 border-stone-950 transition-all duration-200 cursor-pointer hover:scale-110
                {{ $exp->is_current
                    ? 'bg-emerald-400 shadow-[inset_-3px_-4px_6px_rgba(0,0,0,.3),inset_3px_3px_6px_rgba(255,255,255,.45),0_0_28px_rgba(52,211,153,.7)]'
                    : 'bg-violet-500 shadow-[inset_-3px_-4px_6px_rgba(0,0,0,.3),inset_3px_3px_6px_rgba(255,255,255,.4),0_0_22px_rgba(139,92,246,.55)]' }}"
            >
            </button>

            {{-- Time periods: the main one first, then any others for this role --}}
            <p class="font-mono text-xs uppercase tracking-[.15em] text-violet-300 mb-2.5 flex flex-wrap items-center gap-x-3 gap-y-1">
                @foreach($exp->allPeriods() as $period)
                    @if(! $loop->first)
                        <span class="text-stone-600" aria-hidden="true">+</span>
                    @endif
                    <span>{{ $period }}</span>
                @endforeach
            </p>

            {{-- Header --}}
            <button
                type="button"
                wire:click="toggle({{ $exp->id }})"
                aria-expanded="{{ in_array($exp->id, $openItems) ? 'true' : 'false' }}"
                class="group w-full text-left cursor-pointer"
            >
                <div class="flex items-start gap-3">

                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
                            <p class="font-serif text-2xl md:text-4xl leading-[1.05] tracking-tight text-white group-hover:text-violet-200 transition-colors">
                                {{ $exp->role }}
                            </p>

                            @if($exp->is_current)
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs
                                        bg-emerald-400/10 border border-emerald-400/30 text-emerald-300"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Current
                                </span>
                            @endif
                        </div>

                        <p class="text-base text-stone-400 mt-2">
                            <span class="text-violet-300">{{ $exp->company }}</span>
                            {{ $exp->location ? ' · '.$exp->location : '' }}
                        </p>
                    </div>

                    <span class="shrink-0 mt-0.5 w-10 h-10 rounded-full border border-white/15 flex items-center justify-center text-stone-400 group-hover:border-violet-400 group-hover:text-violet-300 transition-colors" aria-hidden="true">
                        <svg
                            class="w-4 h-4 transition-transform duration-300
                            {{ in_array($exp->id, $openItems) ? 'rotate-180' : '' }}"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </span>
                </div>
            </button>

            {{-- Expandable Content --}}
            @if(in_array($exp->id, $openItems))
                <div class="mt-6 space-y-7">

                    @if($exp->company_url)
                        <a href="{{ $exp->company_url }}" target="_blank" rel="noopener"
                           class="inline-flex items-center min-h-11 text-sm text-violet-300 hover:text-white transition-colors">
                            Visit {{ $exp->company }} ↗
                        </a>
                    @endif

                    {{-- Bullets --}}
                    @if($exp->bullets)
                        <ul class="space-y-3 max-w-3xl">
                            @foreach($exp->bullets as $bullet)
                                <li class="relative pl-6 text-[.9375rem] md:text-base text-stone-300 font-light leading-relaxed">
                                    <span class="absolute left-0 top-[.75em] w-3 h-px bg-violet-400"></span>
                                    {{ is_array($bullet) ? ($bullet['bullet'] ?? '') : $bullet }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Sub Projects --}}
                    @if($exp->sub_projects)
                        <div class="grid sm:grid-cols-2 gap-3 md:gap-4">
                            @foreach($exp->sub_projects as $sub)
                                <div data-tilt="dark" class="rounded-2xl border border-white/10 bg-white/[0.04] hover:bg-white/[0.07] hover:border-violet-400/40 transition-colors p-5">

                                    <p class="font-serif text-xl text-white leading-snug">
                                        {{ $sub['name'] ?? '' }}
                                    </p>

                                    @if(!empty($sub['desc']))
                                        <p class="text-sm text-stone-400 mt-2 leading-relaxed">
                                            {{ $sub['desc'] }}
                                        </p>
                                    @endif

                                    @if(!empty($sub['tags']))
                                        <div class="flex flex-wrap gap-1.5 mt-3.5">
                                            @foreach((array) $sub['tags'] as $tag)
                                                <span
                                                    class="px-2.5 py-1 text-xs
                                                        rounded-full
                                                        {{ TechnologyColors::badge($tag) ?? 'bg-stone-100 text-stone-600' }}"
                                                >
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            @endif

        </div>
    @endforeach
</div>
