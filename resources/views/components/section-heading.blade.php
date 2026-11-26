@props(['number', 'label', 'title', 'dark' => false])

{{-- Section opener: numbered mono label, title, optional subtitle (slot). --}}
<div {{ $attributes->class(['reveal mb-10 md:mb-14']) }}>
    <p class="font-mono text-xs tracking-[.25em] uppercase flex items-center gap-3 {{ $dark ? 'text-violet-300' : 'text-violet-600' }}">
        <span>{{ $number }}</span>
        <span class="h-px w-8 bg-current opacity-40"></span>
        <span>{{ $label }}</span>
    </p>

    <h2 class="font-serif text-4xl md:text-5xl leading-[1.02] tracking-tight mt-3 {{ $dark ? 'text-white' : 'text-stone-900' }}">
        {{ $title }}
    </h2>

    @if(! $slot->isEmpty())
        <p class="mt-4 max-w-xl text-base md:text-lg font-light leading-relaxed {{ $dark ? 'text-stone-400' : 'text-stone-500' }}">
            {{ $slot }}
        </p>
    @endif
</div>
