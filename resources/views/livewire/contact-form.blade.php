<div>
    @if($submitted)
        <div class="py-14 text-center space-y-4" role="status">
            <div class="w-14 h-14 mx-auto bg-emerald-400/10 border border-emerald-400/30 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="font-serif text-3xl text-white">Message sent!</p>
            <p class="text-stone-400 font-light">I'll get back to you within 24 hours.</p>
        </div>
    @else
    {{-- Livewire v4: wire:submit (not wire:submit.prevent) --}}
        <form wire:submit="send" class="space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    {{-- wire:model.blur: checks the field when you leave it, instead of sending a request on every keystroke --}}
                    <input
                        wire:model.blur="name"
                        type="text"
                        aria-label="Your name"
                        autocomplete="name"
                        placeholder="Your name"
                        class="w-full h-12 px-4 bg-white/[0.06] border border-white/10 rounded-2xl text-white placeholder-stone-500 focus:outline-none focus:border-violet-400 focus:bg-white/[0.09] transition-colors"
                    >
                    @error('name') <p class="text-sm text-rose-400 mt-2">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input
                        wire:model.blur="email"
                        type="email"
                        aria-label="Your email"
                        autocomplete="email"
                        placeholder="your@email.com"
                        class="w-full h-12 px-4 bg-white/[0.06] border border-white/10 rounded-2xl text-white placeholder-stone-500 focus:outline-none focus:border-violet-400 focus:bg-white/[0.09] transition-colors"
                    >
                    @error('email') <p class="text-sm text-rose-400 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <input
                    wire:model.blur="subject"
                    type="text"
                    aria-label="Subject"
                    placeholder="Subject (optional)"
                    class="w-full h-12 px-4 bg-white/[0.06] border border-white/10 rounded-2xl text-white placeholder-stone-500 focus:outline-none focus:border-violet-400 focus:bg-white/[0.09] transition-colors"
                >
            </div>

            <div>
                <textarea
                    wire:model.blur="message"
                    rows="5"
                    aria-label="Your message"
                    placeholder="Tell me about your project or opportunity…"
                    class="w-full px-4 py-3 bg-white/[0.06] border border-white/10 rounded-2xl text-white placeholder-stone-500 focus:outline-none focus:border-violet-400 focus:bg-white/[0.09] transition-colors resize-none"
                ></textarea>
                @error('message') <p class="text-sm text-rose-400 mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- Honeypot: people never see or reach this field, bots fill it in --}}
            <div class="absolute -left-[9999px] h-0 w-0 overflow-hidden" aria-hidden="true">
                <label>Leave this field empty
                    <input type="text" wire:model="website" tabindex="-1" autocomplete="off">
                </label>
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full h-12 bg-linear-to-r from-violet-600 to-fuchsia-500 text-white text-sm font-medium rounded-2xl shadow-lg shadow-violet-600/30 hover:shadow-violet-500/50 hover:-translate-y-0.5 transition-all disabled:opacity-50 flex items-center justify-center gap-2"
            >
                <span wire:loading.remove wire:target="send">Send message →</span>
                <span wire:loading wire:target="send" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Sending…
                </span>
            </button>
        </form>
    @endif
</div>
