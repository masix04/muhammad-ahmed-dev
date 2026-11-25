{{-- FILE: resources/views/layouts/app.blade.php --}}
{{-- Livewire v4: @livewireStyles and @livewireScripts are still valid --}}
<!DOCTYPE html>
<html lang="en" x-data="{ scrolled: false, menuOpen: false }" @scroll.window="scrolled = window.scrollY > 40" @keydown.escape.window="menuOpen = false">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Muhammad Ahmed — Laravel Developer' }}</title>
    <meta name="description" content="{{ $description ?? 'Software Engineer with 5+ years of experience building full-stack web applications in Laravel and managing AWS cloud infrastructure.' }}">
    <meta name="theme-color" content="#ffffff">

    <link rel="icon" type="image/svg+xml" href="{{ asset('icon.svg') }}">

    {{-- Vite handles CSS (including Tailwind v4) and JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white text-stone-900 antialiased" x-cloak>

    {{-- ── NAVBAR ──────────────────────────────────────────────────────── --}}
    <nav
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="(scrolled || menuOpen)
            ? 'bg-white/90 backdrop-blur-md border-b border-stone-100 shadow-sm'
            : 'bg-transparent'"
    >
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            
            <a href="/" class="logo">
                <!-- Logo mark: MA monogram with purple accent -->
                <svg class="logo-mark" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="8" fill="#534AB7"/>
                    <path d="M7 23V10L13.5 20.5L16 16L18.5 20.5L25 10V23" stroke="#EEEDFE" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    <circle cx="25" cy="23" r="2" fill="#5DCAA5"/>
                </svg>
                <span class="logo-text">Muhammad <span>Ahmed</span></span>
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-light text-stone-500">
                {{-- "/#…" so the links also work from the blog pages --}}
                <a href="/#projects"       class="hover:text-stone-900 transition-colors">Projects</a>
                <a href="/#experience"     class="hover:text-stone-900 transition-colors">Experience</a>
                <a href="/#skills"         class="hover:text-stone-900 transition-colors">Skills</a>
                <a href="/#certifications" class="hover:text-stone-900 transition-colors">Learning</a>
                <a href="/#blog"           class="hover:text-stone-900 transition-colors">Blog</a>
                <a href="/#contact"        class="hover:text-stone-900 transition-colors">Contact</a>
            </div>

            {{-- Mobile menu button --}}
            <button
                type="button"
                class="md:hidden p-2 -mr-2 text-stone-600"
                @click="menuOpen = !menuOpen"
                :aria-expanded="menuOpen.toString()"
                aria-controls="mobile-menu"
                aria-label="Toggle menu"
            >
                <svg x-show="!menuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
                <svg x-show="menuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </button>

            {{--<a
                href="{{ asset('storage/cv/muhammad-ahmed-cv.pdf') }}"
                target="_blank"
                class="hidden md:inline-flex items-center gap-2 text-sm px-4 py-2 border border-stone-200 rounded-full hover:bg-stone-50 transition-colors text-stone-600"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download CV
            </a>--}}
        </div>

        {{-- Mobile menu panel --}}
        <div id="mobile-menu" x-show="menuOpen" x-cloak x-transition.opacity
             class="md:hidden bg-white/95 backdrop-blur-md border-b border-stone-100">
            <div class="max-w-6xl mx-auto px-6 py-4 flex flex-col text-sm text-stone-600">
                @foreach([
                    '/#projects' => 'Projects',
                    '/#experience' => 'Experience',
                    '/#skills' => 'Skills',
                    '/#certifications' => 'Learning',
                    '/#blog' => 'Blog',
                    '/#contact' => 'Contact',
                ] as $href => $label)
                    <a href="{{ $href }}" @click="menuOpen = false"
                       class="py-3 border-b border-stone-100 last:border-0 hover:text-stone-900 transition-colors">{{ $label }}</a>
                @endforeach
            </div>
        </div>
    </nav>

    {{-- ── MAIN ────────────────────────────────────────────────────────── --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ── FOOTER ──────────────────────────────────────────────────────── --}}
    <footer class="border-t border-stone-100 py-10 mt-20">
        <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-stone-400">
            <p>© {{ date('Y') }} Muhammad Ahmed. Built with Laravel {{ app()->version() }}, Livewire & Three.js.</p>
            <div class="flex items-center gap-5">
                <a href="https://github.com/masix04" target="_blank" class="hover:text-stone-700 transition-colors">GitHub</a>
                <a href="https://www.linkedin.com/in/muhammad-ahmed-61b21b163/" target="_blank" class="hover:text-stone-700 transition-colors">LinkedIn</a>
                <a href="mailto:muhammadahmed5867@gmail.com" class="hover:text-stone-700 transition-colors">Email</a>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>