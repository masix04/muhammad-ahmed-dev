<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
    @forelse($certifications as $cert)

        <div
            class="bg-white border border-stone-200 rounded-xl p-4 flex flex-col gap-3 transition-all duration-150 hover:border-violet-300"
        >

            {{-- Icon --}}
            <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center flex-shrink-0">
                <svg
                    class="w-4 h-4 text-violet-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                    />
                </svg>
            </div>

            {{-- Content --}}
            <div class="flex-1">

                <p class="text-sm font-medium text-stone-900 leading-snug">
                    {{ $cert->title }}
                </p>

                <p class="text-[11px] text-stone-500 mt-1">
                    {{ $cert->issuer }}
                </p>

                @if($cert->issued_date)
                    <p class="text-[10px] text-stone-400 mt-0.5">
                        {{ $cert->issued_date }}
                    </p>
                @endif

                @if($cert->description)
                    <p class="text-[11px] text-stone-500 leading-relaxed mt-2">
                        {{ $cert->description }}
                    </p>
                @endif

            </div>

            {{-- Verify Link --}}
            @if($cert->verification_url)
                <a
                    href="{{ $cert->verification_url }}"
                    target="_blank"
                    class="inline-flex items-center gap-1 text-[11px] text-violet-600 hover:text-violet-700 transition-colors mt-auto"
                >
                    Verify Certificate

                    <svg
                        class="w-3 h-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                        />
                    </svg>
                </a>
            @endif

        </div>

    @empty

        <p class="col-span-full text-sm text-stone-500 py-8 text-center">
            No certifications added yet.
        </p>

    @endforelse
</div>
