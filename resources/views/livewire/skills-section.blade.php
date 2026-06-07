<div>

    @php
        use App\Support\TechnologyColors;
    @endphp

    {{-- Category Filters --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @foreach($categories as $cat)
            <button
                wire:click="$set('activeCategory', @js($cat))"
                class="px-4 py-1.5 rounded-full text-xs transition-all cursor-pointer border
                {{ TechnologyColors::light($cat) }}
                {{ $activeCategory === $cat ? 'ring-2 ring-offset-1 ring-current' : '' }}"
            >
                {{ $cat }}
            </button>
        @endforeach
    </div>

    {{-- Skills Cloud --}}
    <div class="flex flex-wrap gap-2">

        @foreach($this->filtered as $skill)

            <div class="inline-flex items-center gap-2 px-3 py-2 rounded-full
                    border border-stone-200 bg-white
                    text-sm text-stone-700
                    hover:border-stone-300 transition-all"
            >
                <span class="w-2 h-2 rounded-full
                    {{ TechnologyColors::dotByCategory($skill->category) }}"
                ></span>

                {{ $skill->name }}
            </div>

        @endforeach

    </div>

</div>
