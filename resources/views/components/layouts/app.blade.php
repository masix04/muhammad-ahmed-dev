{{-- FILE: resources/views/components/layouts/app.blade.php --}}
{{-- Livewire v4: @livewireStyles and @livewireScripts are still valid --}}
{{-- Pass :hero-dark="true" on pages that open with a dark hero: the nav then starts light-on-dark. --}}
<!DOCTYPE html>
<html lang="en"
      x-data="{ scrolled: false, menuOpen: false, heroDark: @js((bool) ($heroDark ?? false)) }"
      @scroll.window="scrolled = window.scrollY > 40"
      @keydown.escape.window="menuOpen = false">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        use App\Models\SiteSetting;

        $siteName    = SiteSetting::get('hero_name', 'Muhammad Ahmed');
        $pageTitle   = $title ?? $siteName . ' — Laravel Developer';
        $pageDesc    = $description ?? 'Software Engineer with 5+ years of experience building full-stack web applications in Laravel and managing AWS cloud infrastructure.';
        $pageType    = $type ?? 'website';
        $shareImage  = SiteSetting::url('og_image');
        $cvUrl       = SiteSetting::url('cv_url');
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="theme-color" content="#0c0a09">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Twitter: the preview shown when the link is shared --}}
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:type" content="{{ $pageType }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="{{ $shareImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    @if($shareImage)
        <meta property="og:image" content="{{ $shareImage }}">
        <meta name="twitter:image" content="{{ $shareImage }}">
    @endif
    @stack('head')

    <link rel="icon" type="image/svg+xml" href="{{ asset('icon.svg') }}">

    {{-- Lets the CSS hide .reveal elements until they scroll in — only when JavaScript is running --}}
    <script>document.documentElement.classList.add('js')</script>

    {{-- Vite handles CSS (including Tailwind v4) and JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white text-stone-900 antialiased" x-cloak>

    {{-- ── NAVBAR: a floating pill. Links sit in the bar from "lg" (laptops);
         phones AND tablets get the menu button instead. ─────────────────── --}}
    <nav class="fixed top-0 left-0 right-0 z-50 px-3 sm:px-5 pt-3 sm:pt-4"
         :class="(heroDark && !scrolled && !menuOpen) ? 'nav-dark' : ''">

        <div class="max-w-6xl mx-auto h-14 pl-4 pr-2 md:pl-5 rounded-full border flex items-center justify-between gap-3 transition-all duration-300"
             :class="(heroDark && !scrolled && !menuOpen)
                ? 'bg-white/5 border-white/10 text-stone-300 backdrop-blur-md'
                : 'bg-white/85 border-stone-200 text-stone-600 shadow-lg shadow-stone-900/5 backdrop-blur-xl'">

            <a href="/" class="logo -ml-1.5 p-1.5" aria-label="{{ $siteName }} — home">
                <!-- Logo mark: MA monogram with purple accent -->
                <svg class="logo-mark" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="8" fill="#534AB7"/>
                    <path d="M7 23V10L13.5 20.5L16 16L18.5 20.5L25 10V23" stroke="#EEEDFE" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    <circle cx="25" cy="23" r="2" fill="#5DCAA5"/>
                </svg>
                <span class="logo-text hidden min-[400px]:inline text-sm font-medium" :class="(heroDark && !scrolled && !menuOpen) ? 'text-white' : 'text-stone-900'">{{ $siteName }}</span>
            </a>

            <div class="nav-links relative hidden lg:flex items-center gap-7 text-sm">
                {{-- Slides under whichever section is on screen (see initScrollSpy in app.js) --}}
                <span class="nav-underline" aria-hidden="true"></span>
                {{-- "/#…" so the links also work from the blog pages --}}
                @if(SiteSetting::get('about_text'))
                    <a href="/#about"      data-spy-link class="py-3 opacity-70 hover:opacity-100 transition-opacity">About</a>
                @endif
                <a href="/#projects"       data-spy-link class="py-3 opacity-70 hover:opacity-100 transition-opacity">Projects</a>
                <a href="/#experience"     data-spy-link class="py-3 opacity-70 hover:opacity-100 transition-opacity">Experience</a>
                <a href="/#skills"         data-spy-link class="py-3 opacity-70 hover:opacity-100 transition-opacity">Skills</a>
                <a href="/#certifications" data-spy-link class="py-3 opacity-70 hover:opacity-100 transition-opacity">Learning</a>
                <a href="/#blog"           data-spy-link class="py-3 opacity-70 hover:opacity-100 transition-opacity">Blog</a>
            </div>

            <div class="flex items-center gap-2">
                @if($cvUrl)
                    <a
                        href="{{ $cvUrl }}"
                        target="_blank"
                        rel="noopener"
                        class="hidden lg:inline-flex items-center gap-2 text-sm px-4 py-2 rounded-full border transition-colors"
                        :class="(heroDark && !scrolled && !menuOpen) ? 'border-white/20 text-white hover:bg-white/10' : 'border-stone-200 text-stone-700 hover:bg-stone-50'"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download CV
                    </a>
                @endif

                <a href="/#contact"
                   class="hidden md:inline-flex items-center text-sm font-medium px-5 py-2.5 rounded-full bg-violet-600 text-white hover:bg-violet-500 transition-colors">
                    Let's talk
                </a>

                {{-- Menu button (phones and tablets) --}}
                <button
                    type="button"
                    class="lg:hidden w-11 h-11 flex items-center justify-center rounded-full"
                    @click="menuOpen = !menuOpen"
                    :aria-expanded="menuOpen.toString()"
                    aria-controls="mobile-menu"
                    aria-label="Toggle menu"
                >
                    <svg x-show="!menuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8h16M4 16h16"/>
                    </svg>
                    <svg x-show="menuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6l12 12M18 6L6 18"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu panel --}}
        <div id="mobile-menu" x-show="menuOpen" x-cloak x-transition.opacity
             class="lg:hidden max-w-6xl mx-auto mt-2 rounded-3xl bg-white/95 backdrop-blur-xl border border-stone-200 shadow-xl shadow-stone-900/10 overflow-hidden max-h-[calc(100dvh-5.5rem)] overflow-y-auto">
            <div class="px-6 py-2 flex flex-col text-base text-stone-700">
                @foreach(array_filter([
                    '/#about' => SiteSetting::get('about_text') ? 'About' : null,
                    '/#projects' => 'Projects',
                    '/#experience' => 'Experience',
                    '/#skills' => 'Skills',
                    '/#certifications' => 'Learning',
                    '/#blog' => 'Blog',
                    '/#contact' => 'Contact',
                ]) as $href => $label)
                    <a href="{{ $href }}" data-spy-link @click="menuOpen = false"
                       class="flex items-center min-h-12 border-b border-stone-100 last:border-0 hover:text-violet-600 transition-colors">{{ $label }}</a>
                @endforeach
                @if($cvUrl)
                    <a href="{{ $cvUrl }}" target="_blank" rel="noopener"
                       class="flex items-center min-h-12 text-violet-700 hover:text-violet-900 transition-colors">Download CV ↓</a>
                @endif
            </div>
        </div>
    </nav>

    {{-- ── MAIN ────────────────────────────────────────────────────────── --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ── FOOTER ──────────────────────────────────────────────────────── --}}
    <footer class="bg-stone-950 text-stone-500 border-t border-white/10 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row items-center justify-between gap-3 text-sm text-center md:text-left">
            <p>© {{ date('Y') }} {{ $siteName }}. Built with Laravel {{ app()->version() }}, Livewire & Alpine.js.</p>
            <div class="flex items-center gap-6">
                @if($github = SiteSetting::get('github_url'))
                    <a href="{{ $github }}" target="_blank" rel="noopener" class="inline-flex items-center min-h-11 px-2 hover:text-white transition-colors">GitHub</a>
                @endif
                @if($linkedin = SiteSetting::get('linkedin_url'))
                    <a href="{{ $linkedin }}" target="_blank" rel="noopener" class="inline-flex items-center min-h-11 px-2 hover:text-white transition-colors">LinkedIn</a>
                @endif
                @if($email = SiteSetting::get('email'))
                    <a href="mailto:{{ $email }}" class="inline-flex items-center min-h-11 px-2 hover:text-white transition-colors">Email</a>
                @endif
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
