@php
    use App\Models\SiteSetting;

    $name      = SiteSetting::get('hero_name', 'Muhammad Ahmed');
    $github    = SiteSetting::get('github_url');
    $linkedin  = SiteSetting::get('linkedin_url');
    $email     = SiteSetting::get('email');
    $phone     = SiteSetting::get('phone');
    $location  = SiteSetting::get('location', 'Lahore, Pakistan');
    $cvUrl     = SiteSetting::url('cv_url');
    $stats     = SiteSetting::pairs('hero_stats');
    $about     = array_filter(preg_split('/\R{2,}/', trim((string) SiteSetting::get('about_text'))));
    $photo     = SiteSetting::url('profile_photo');

    // "https://www.linkedin.com/in/x/" → "linkedin.com/in/x"
    $display = fn (?string $url) => preg_replace('#^https?://(www\.)?#i', '', rtrim((string) $url, '/'));

    $personSchema = array_filter([
        '@context'   => 'https://schema.org',
        '@type'      => 'Person',
        'name'       => $name,
        'jobTitle'   => SiteSetting::get('hero_title'),
        'url'        => url('/'),
        'image'      => $photo,
        'sameAs'     => array_values(array_filter([$github, $linkedin])),
        'address'    => $location ? ['@type' => 'PostalAddress', 'addressLocality' => $location] : null,
    ]);
@endphp

<x-layouts.app>

    @push('head')
        <script type="application/ld+json">{!! json_encode($personSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    @endpush

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- HERO SECTION                                                    --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}

    <section id="hero" class="relative min-h-screen flex items-center overflow-hidden">

        {{-- Background Glow --}}
        <div class="absolute inset-0">
            <div class="absolute top-20 right-20 w-72 h-72 bg-violet-300/20 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-10 left-10 w-80 h-80 bg-emerald-300/20 blur-[120px] rounded-full"></div>
        </div>

        {{-- Grid Overlay --}}
        <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,0.03)_1px,transparent_1px)] bg-[size:64px_64px]"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 pt-24 pb-16 grid lg:grid-cols-2 gap-16 items-center">

            {{-- LEFT SIDE (UNCHANGED) --}}
            <div class="space-y-6">

                @if(SiteSetting::get('open_to_work'))
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-200 rounded-full text-xs text-emerald-700">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        Open to opportunities · {{ SiteSetting::get('location', 'Lahore, Pakistan') }}
                    </div>
                @endif

                <div>
                    <p class="text-sm font-light text-stone-400 tracking-widest uppercase mb-2">
                        {{ SiteSetting::get('hero_title', 'Software Engineer · Laravel & AWS') }}
                    </p>

                    @php [$firstName, $lastName] = array_pad(explode(' ', $name, 2), 2, ''); @endphp
                    <h1 class="font-serif text-6xl md:text-7xl leading-none text-stone-900">
                        {{ $firstName }}<br>
                        <em class="not-italic text-violet-600">{{ $lastName }}</em>
                    </h1>
                </div>

                <p class="text-stone-500 font-light leading-relaxed max-w-md">
                    {{ SiteSetting::get('hero_tagline') }}
                </p>

                @if($building = SiteSetting::get('currently_building'))
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-violet-200 bg-violet-50 text-xs text-violet-700">
                        <span class="w-2 h-2 bg-violet-500 rounded-full animate-pulse"></span>
                        {{ $building }}
                    </div>
                @endif

                @if($stats)
                    <div class="flex flex-wrap gap-x-8 gap-y-4 pt-2">
                        @foreach($stats as [$n, $l])
                            <div>
                                <div class="font-serif text-2xl text-stone-900">{{ $n }}</div>
                                <div class="text-xs text-stone-400 mt-0.5">{{ $l }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-wrap gap-3 pt-2">
                    <a href="#projects"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-violet-600 text-white text-sm rounded-full hover:bg-violet-700">
                        View Projects
                    </a>

                    @if($cvUrl)
                        <a href="{{ $cvUrl }}" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 px-5 py-2.5 border border-stone-200 text-stone-700 text-sm rounded-full hover:bg-stone-50">
                            Download CV
                        </a>
                    @endif

                    @if($github)
                        <a href="{{ $github }}" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 px-5 py-2.5 border border-violet-200 text-violet-700 rounded-full hover:bg-violet-50">
                            GitHub
                        </a>
                    @endif

                    @if($linkedin)
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 px-5 py-2.5 border border-emerald-200 text-emerald-700 rounded-full hover:bg-emerald-50">
                            LinkedIn
                        </a>
                    @endif
                </div>

            </div>

            {{-- RIGHT SIDE --}}
            <div class="hidden lg:block relative h-[600px]">

                <div id="workspace"
                    class="absolute inset-0 perspective-[1800px]">

                    <div id="workspace-inner"
                        class="relative w-full h-full transform-gpu">

                        @php
                            // Spots for featured projects that have no saved position (for example
                            // ones created in the admin panel): [top %, left %].
                            $heroSlots = [[10, 55], [38, 8], [25, 65], [62, 40], [72, 70], [80, 15], [50, 30]];
                        @endphp

                        @foreach($featuredProjects as $i => $project)
                            @php
                                $hasPosition = $project->top_class && $project->left_class;
                                [$slotTop, $slotLeft] = $heroSlots[$i % count($heroSlots)];
                            @endphp
                            <div class="workspace-card absolute {{ $project->top_class }} {{ $project->left_class }}"
                                @unless($hasPosition) style="top: {{ $slotTop }}%; left: {{ $slotLeft }}%" @endunless
                                data-depth="">

                                <h3>{{ $project->title }}</h3>

                                <p>{{ $project->category }}</p>

                                <div class="tags">
                                    @foreach(array_slice($project->tech_tags ?? [], 0, 3) as $tag)
                                        <span>{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 text-stone-300 animate-bounce">
            <span class="text-xs tracking-widest">SCROLL</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- ABOUT                                                           --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    @if($about)
        <section id="about" class="max-w-6xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-[1fr_2fr] gap-10 md:gap-16 items-start">
                <div>
                    <p class="text-xs tracking-widest text-stone-400 uppercase mb-2">About</p>
                    <h2 class="font-serif text-4xl text-stone-900">A bit about me</h2>

                    @if($photo)
                        <img src="{{ $photo }}" alt="Photo of {{ $name }}" loading="lazy"
                             class="mt-8 w-48 h-48 md:w-full md:max-w-[16rem] aspect-square object-cover rounded-2xl">
                    @endif
                </div>

                <div class="space-y-5 text-stone-600 font-light leading-relaxed">
                    @foreach($about as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach

                    @if($location || $cvUrl)
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-3 pt-2 text-sm">
                            @if($location)
                                <span class="text-stone-400">📍 {{ $location }}</span>
                            @endif
                            @if($cvUrl)
                                <a href="{{ $cvUrl }}" target="_blank" rel="noopener"
                                   class="text-violet-700 hover:text-violet-900 transition-colors">Download my CV →</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- PROJECTS                                                        --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="projects" class="max-w-6xl mx-auto px-6 py-12">
        <div class="mb-12">
            <p class="text-xs tracking-widest text-stone-400 uppercase mb-2">Work</p>
            <h2 class="font-serif text-4xl text-stone-900">Featured Projects</h2>
            <p class="mt-3 text-stone-400 font-light max-w-lg">
                Click any card for screenshots, demo videos, tech breakdown, and links.
            </p>
        </div>

        @livewire('projects-grid')
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- CAREER TIMELINE                                                 --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="experience" class="bg-stone-50 py-12">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-12">
                <p class="text-xs tracking-widest text-stone-400 uppercase mb-2">Career</p>
                <h2 class="font-serif text-4xl text-stone-900">Experience</h2>
                <p class="mt-3 text-stone-400 font-light">Click any role to see what I built there.</p>
            </div>
            @livewire('career-timeline')
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SKILLS                                                          --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="skills" class="max-w-6xl mx-auto px-6 py-12">
        <div class="mb-12">
            <p class="text-xs tracking-widest text-stone-400 uppercase mb-2">Expertise</p>
            <h2 class="font-serif text-4xl text-stone-900">Technical Skills</h2>
        </div>
        @livewire('skills-section')
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- CERTIFICATIONS                                                  --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="certifications" class="bg-stone-50 py-12">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-12">
                <p class="text-xs tracking-widest text-stone-400 uppercase mb-2">Learning</p>
                <h2 class="font-serif text-4xl text-stone-900">Certifications & Courses</h2>
            </div>
            @livewire('certifications-section')
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- BLOG                                                            --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="blog" class="max-w-6xl mx-auto px-6 py-12">
        <div class="mb-12">
            <p class="text-xs tracking-widest text-stone-400 uppercase mb-2">Writing</p>
            <h2 class="font-serif text-4xl text-stone-900">Dev Notes</h2>
            <p class="mt-3 text-stone-400 font-light">Things I've learned, built, or debugged.</p>
        </div>
        @livewire('blog-section')
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- CONTACT                                                         --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="contact" class="bg-stone-900 text-white py-12">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-start">
            <div>
                <p class="text-xs tracking-widest text-stone-500 uppercase mb-2">Get in touch</p>
                <h2 class="font-serif text-4xl text-white mb-6">Let's work together.</h2>
                <p class="text-stone-400 font-light leading-relaxed mb-8">
                    Open to full-time roles, freelance contracts, and interesting side projects.
                    @if($location) Based in {{ $location }} — @endif available remotely worldwide.
                </p>
                <div class="space-y-3 text-sm text-stone-400">
                    @if($email)
                        <a href="mailto:{{ $email }}" class="flex items-center gap-3 hover:text-white transition-colors">
                            <span class="text-stone-600">✉</span> {{ $email }}
                        </a>
                    @endif
                    @if($phone)
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="flex items-center gap-3 hover:text-white transition-colors">
                            <span class="text-stone-600">☎</span> {{ $phone }}
                        </a>
                    @endif
                    @if($linkedin)
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener" class="flex items-center gap-3 hover:text-white transition-colors">
                            <span class="text-stone-600">in</span> {{ $display($linkedin) }}
                        </a>
                    @endif
                    @if($github)
                        <a href="{{ $github }}" target="_blank" rel="noopener" class="flex items-center gap-3 hover:text-white transition-colors">
                            <span class="text-stone-600">⌥</span> {{ $display($github) }}
                        </a>
                    @endif
                </div>
            </div>
            <div>
                @livewire('contact-form')
            </div>
        </div>
    </section>

</x-layouts.app>
