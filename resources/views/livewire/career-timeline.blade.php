@php
    use App\Support\TechnologyColors;
@endphp

<div class="relative pl-5">
    <div class="absolute left-[6px] top-1 bottom-1 w-px bg-stone-200"></div>

    @foreach($experiences as $exp)
        <div class="relative mb-5">

            {{-- Timeline Dot --}}
            <button
                wire:click="toggle({{ $exp->id }})"
                class="absolute -left-[14px] top-[5px] w-3 h-3 rounded-full border-2 transition-all duration-200 cursor-pointer
                {{ $exp->is_current
                    ? 'bg-emerald-500 border-white'
                    : 'bg-violet-600 border-white' }}"
                aria-label="Toggle {{ $exp->role }}"
            >
            </button>

            {{-- Period --}}
            <p class="text-[10px] text-stone-500 tracking-wide mb-1">
                {{ $exp->period }}
            </p>

            {{-- Header --}}
            <button
                wire:click="toggle({{ $exp->id }})"
                class="w-full text-left cursor-pointer"
            >
                <div class="flex items-center gap-2">

                    <p class="text-[13px] font-medium text-stone-900">
                        {{ $exp->role }}
                    </p>

                    @if($exp->is_current)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px]
                                bg-emerald-50 border border-emerald-200 text-emerald-700"
                        >
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Current
                        </span>
                    @endif

                    <svg
                        class="w-4 h-4 ml-auto text-stone-400 transition-transform duration-200
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
                </div>

                <p class="text-xs text-violet-600 mt-0.5">
                    {{ $exp->company }}
                    {{ $exp->location ? ' · '.$exp->location : '' }}
                </p>
            </button>

            {{-- Expandable Content --}}
            @if(in_array($exp->id, $openItems))
                <div class="mt-3 space-y-4">

                    {{-- Bullets --}}
                    @if($exp->bullets)
                        <ul class="space-y-1">
                            @foreach($exp->bullets as $bullet)
                                <li class="relative pl-3 text-[11px] text-stone-600 leading-relaxed">
                                    <span class="absolute left-0 text-violet-300">–</span>
                                    {{ is_array($bullet) ? ($bullet['bullet'] ?? '') : $bullet }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Sub Projects --}}
                    @if($exp->sub_projects)
                        <div class="space-y-3 pt-2">
                            @foreach($exp->sub_projects as $sub)
                                <div class="pl-4 border-l border-stone-200">

                                    <p class="text-sm font-medium text-stone-800">
                                        {{ $sub['name'] ?? '' }}
                                    </p>

                                    @if(!empty($sub['desc']))
                                        <p class="text-xs text-stone-500 mt-1 leading-relaxed">
                                            {{ $sub['desc'] }}
                                        </p>
                                    @endif

                                    @if(!empty($sub['tags']))
                                        <div class="flex flex-wrap gap-1.5 mt-2">
                                            @foreach((array) $sub['tags'] as $tag)
                                                <span
                                                    class="px-2 py-0.5 text-[10px]
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
