<div>

    @php
        use App\Support\TechnologyColors;
    @endphp

    {{-- Category filter: one scrolling row on phones, wrapping chips from "sm" up --}}
    <div class="mb-8 inline-flex max-w-full overflow-x-auto gap-1 p-1 rounded-full bg-white/80 border border-stone-300/70 snap-x" role="group" aria-label="Filter skills by category">
        @foreach($categories as $cat)
            <button
                type="button"
                wire:click="$set('activeCategory', @js($cat))"
                aria-pressed="{{ $activeCategory === $cat ? 'true' : 'false' }}"
                class="shrink-0 snap-start inline-flex items-center gap-2 h-10 px-4 rounded-full text-sm cursor-pointer transition-colors duration-200
                {{ $activeCategory === $cat ? 'bg-stone-900 text-white shadow-md shadow-stone-900/20' : 'text-stone-600 hover:bg-stone-100 hover:text-stone-900' }}"
            >
                @if($cat !== 'All')
                    <span class="w-1.5 h-1.5 rounded-full {{ TechnologyColors::dotByCategory($cat) }}" aria-hidden="true"></span>
                @endif
                {{ $cat }}
            </button>
        @endforeach
    </div>

    {{-- Skills Cloud --}}
    <div class="flex flex-wrap gap-2">

        @foreach($filtered as $skill)

            <div wire:key="skill-{{ $skill->id }}"
                 class="group inline-flex items-center gap-2 min-h-9 px-3.5 py-1.5 rounded-lg
                    border border-stone-200 bg-white
                    text-[.8125rem] text-stone-800
                    hover:border-stone-900 hover:shadow-sm transition-colors duration-200"
            >
                <span class="w-2 h-2 shrink-0 rounded-full group-hover:scale-125 transition-transform
                    {{ TechnologyColors::dotByCategory($skill->category) }}"
                ></span>

                {{ $skill->name }}
            </div>

        @endforeach

    </div>

</div>
