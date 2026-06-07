<div>
    @if($submitted)
        <div class="py-16 text-center space-y-4">
            <div class="w-12 h-12 mx-auto bg-emerald-900/40 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-white font-medium">Message sent!</p>
            <p class="text-stone-400 text-sm font-light">I'll get back to you within 24 hours.</p>
        </div>
    @else
    {{-- Livewire v4: wire:submit (not wire:submit.prevent) --}}
        <form wire:submit="send" class="space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    {{-- Livewire v4: wire:model.live (was wire:model.lazy or wire:model.defer in v3) --}}
                    <input
                        wire:model.live="name"
                        type="text"
                        placeholder="Your name"
                        class="w-full px-4 py-3 bg-stone-800 border border-stone-700 rounded-xl text-white placeholder-stone-500 text-sm focus:outline-none focus:border-stone-500 transition-colors"
                    >
                    @error('name') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input
                        wire:model.live="email"
                        type="email"
                        placeholder="your@email.com"
                        class="w-full px-4 py-3 bg-stone-800 border border-stone-700 rounded-xl text-white placeholder-stone-500 text-sm focus:outline-none focus:border-stone-500 transition-colors"
                    >
                    @error('email') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <input
                    wire:model.live="subject"
                    type="text"
                    placeholder="Subject (optional)"
                    class="w-full px-4 py-3 bg-stone-800 border border-stone-700 rounded-xl text-white placeholder-stone-500 text-sm focus:outline-none focus:border-stone-500 transition-colors"
                >
            </div>

            <div>
                <textarea
                    wire:model.live="message"
                    rows="5"
                    placeholder="Tell me about your project or opportunity…"
                    class="w-full px-4 py-3 bg-stone-800 border border-stone-700 rounded-xl text-white placeholder-stone-500 text-sm focus:outline-none focus:border-stone-500 transition-colors resize-none"
                ></textarea>
                @error('message') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="w-full py-3 bg-white text-stone-900 font-medium text-sm rounded-xl hover:bg-stone-100 transition-colors disabled:opacity-50 flex items-center justify-center gap-2"
            >
                <span wire:loading.remove wire:target="send">Send message</span>
                <span wire:loading wire:target="send" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Sending…
                </span>
            </button>
        </form>
    @endif
</div>
