<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
    @forelse($certifications as $cert)

        <div
            wire:key="cert-{{ $cert->id }}"
            class="group relative bg-white border border-stone-200 rounded-3xl p-5 md:p-6 flex flex-col gap-4 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-violet-300 hover:shadow-xl hover:shadow-violet-500/10"
        >
            <div class="absolute inset-x-0 top-0 h-1 bg-linear-to-r from-violet-500 via-fuchsia-400 to-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity"></div>

            @if($cert->certificate_image)
                <img src="{{ Storage::url($cert->certificate_image) }}"
                     alt="Certificate: {{ $cert->title }}" loading="lazy"
                     class="w-full aspect-[4/3] object-cover rounded-xl border border-stone-100">
            @else
            {{-- Icon --}}
            <div class="w-11 h-11 rounded-2xl bg-violet-100 flex items-center justify-center flex-shrink-0 group-hover:bg-violet-600 transition-colors">
                <svg
                    class="w-5 h-5 text-violet-600 group-hover:text-white transition-colors"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                    />
                </svg>
            </div>
            @endif

            {{-- Content --}}
            <div class="flex-1">

                <p class="font-serif text-xl text-stone-900 leading-snug">
                    {{ $cert->title }}
                </p>

                <p class="text-sm text-stone-600 mt-1.5">
                    {{ $cert->issuer }}
                </p>

                @if($cert->issued_date)
                    <p class="font-mono text-xs text-stone-400 mt-1">
                        {{ $cert->issued_date }}
                    </p>
                @endif

                @if($cert->description)
                    <p class="text-sm text-stone-500 leading-relaxed mt-3">
                        {{ $cert->description }}
                    </p>
                @endif

            </div>

            {{-- Verify Link --}}
            @if($cert->verification_url)
                <a
                    href="{{ $cert->verification_url }}"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex items-center gap-1 min-h-11 text-sm font-medium text-violet-600 hover:text-violet-800 transition-colors mt-auto"
                >
                    Verify Certificate ↗
                </a>
            @endif

        </div>

    @empty

        <p class="col-span-full text-sm text-stone-500 py-8 text-center">
            No certifications added yet.
        </p>

    @endforelse
</div>
