<div>

    @php
        use App\Support\TechnologyColors;
    @endphp

    {{-- Category filter: one scrolling row on phones, wrapping chips from "sm" up --}}
    <div class="flex gap-2 mb-8 overflow-x-auto sm:flex-wrap sm:overflow-visible -mx-4 px-4 sm:mx-0 sm:px-0 pb-2 sm:pb-0 snap-x" role="group" aria-label="Filter skills by category">
        @foreach($categories as $cat)
            <button
                type="button"
                wire:click="$set('activeCategory', @js($cat))"
                aria-pressed="{{ $activeCategory === $cat ? 'true' : 'false' }}"
                class="shrink-0 snap-start h-10 px-5 rounded-full text-sm transition-all cursor-pointer border hover:-translate-y-0.5
                {{ TechnologyColors::light($cat) }}
                {{ $activeCategory === $cat ? 'ring-2 ring-offset-2 ring-stone-900 font-medium' : '' }}"
            >
                {{ $cat }}
            </button>
        @endforeach
    </div>

    {{-- Skills Cloud --}}
    <div class="flex flex-wrap gap-2.5">

        @foreach($filtered as $skill)

            <div wire:key="skill-{{ $skill->id }}"
                 class="group inline-flex items-center gap-2.5 min-h-10 px-4 py-2 rounded-full
                    border border-stone-200 bg-white
                    text-sm text-stone-800
                    hover:-translate-y-0.5 hover:border-stone-900 hover:shadow-md hover:shadow-stone-900/10 transition-all duration-200"
            >
                <span class="w-2.5 h-2.5 shrink-0 rounded-full group-hover:scale-125 transition-transform
                    {{ TechnologyColors::dotByCategory($skill->category) }}"
                ></span>

                {{ $skill->name }}
            </div>

        @endforeach

    </div>

</div>
