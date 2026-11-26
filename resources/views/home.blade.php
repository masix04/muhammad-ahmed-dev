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
    $about     = array_values(array_filter(preg_split('/\R{2,}/', trim((string) SiteSetting::get('about_text')))));
    $photo     = SiteSetting::url('profile_photo');

    // "https://www.linkedin.com/in/x/" → "linkedin.com/in/x"
    $display = fn (?string $url) => preg_replace('#^https?://(www\.)?#i', '', rtrim((string) $url, '/'));

    // Written out in full (not built from a number) so Tailwind can find the classes.
    $statColumns = [1 => 'sm:grid-cols-1', 2 => 'sm:grid-cols-2', 3 => 'sm:grid-cols-3'][count($stats)] ?? 'sm:grid-cols-4';

    // Section numbers (01, 02, ...) follow the order the sections are drawn, so hiding
    // the About section does not leave a gap. A plain lookup: it gives the same answer
    // however many times Blade evaluates it.
    $sectionOrder = array_keys(array_filter([
        'about' => (bool) $about, 'projects' => true, 'experience' => true, 'skills' => true,
        'learning' => true, 'writing' => true, 'contact' => true,
    ]));
    $num = fn (string $section) => sprintf('%02d', array_search($section, $sectionOrder) + 1);

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

<x-layouts.app :hero-dark="true">

    @push('head')
        <script type="application/ld+json">{!! json_encode($personSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
    @endpush

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- HERO                                                            --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}

    <section id="hero" class="relative min-h-[100svh] flex items-center overflow-hidden bg-stone-950 text-white">

        {{-- Glows --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-24 -right-24 w-[420px] md:w-[560px] h-[420px] md:h-[560px] bg-violet-600/35 blur-[130px] md:blur-[150px] rounded-full"></div>
            <div class="absolute -bottom-32 -left-24 w-[380px] md:w-[520px] h-[380px] md:h-[520px] bg-emerald-400/20 blur-[130px] md:blur-[150px] rounded-full"></div>
            <div class="absolute top-1/3 left-1/3 w-72 h-72 bg-fuchsia-500/10 blur-[130px] rounded-full"></div>
        </div>

        {{-- Grid overlay, fading out toward the edges --}}
        <div class="absolute inset-0 pointer-events-none bg-[linear-gradient(rgba(255,255,255,0.045)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.045)_1px,transparent_1px)] bg-[size:72px_72px] [mask-image:radial-gradient(ellipse_at_center,black_35%,transparent_75%)]"></div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 pt-28 pb-32 md:pb-36 grid grid-cols-[minmax(0,1fr)] lg:grid-cols-[1.1fr_minmax(0,1fr)] gap-10 lg:gap-12 items-center">

            {{-- LEFT SIDE --}}
            <div class="space-y-6 min-w-0">

                <div class="flex flex-wrap gap-3">
                    @if(SiteSetting::get('open_to_work'))
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-emerald-400/10 border border-emerald-400/30 rounded-full text-xs text-emerald-300">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                            Open to opportunities · {{ $location }}
                        </div>
                    @endif

                    @if($building = SiteSetting::get('currently_building'))
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-violet-400/30 bg-violet-400/10 text-xs text-violet-200">
                            <span class="w-1.5 h-1.5 bg-violet-400 rounded-full animate-pulse"></span>
                            {{ $building }}
                        </div>
                    @endif
                </div>

                <div>
                    <p class="font-mono text-xs text-stone-400 tracking-[.25em] uppercase mb-4">
                        {{ SiteSetting::get('hero_title', 'Software Engineer · Laravel & AWS') }}
                    </p>

                    @php [$firstName, $lastName] = array_pad(explode(' ', $name, 2), 2, ''); @endphp
                    <h1 class="font-serif text-[clamp(2.75rem,7vw,5.5rem)] leading-[.92] tracking-tight text-white">
                        {{ $firstName }}<br>
                        <em class="text-gradient pr-3">{{ $lastName }}</em>
                    </h1>
                </div>

                <p class="text-stone-300 text-base md:text-lg font-light leading-relaxed max-w-xl">
                    {{ SiteSetting::get('hero_tagline') }}
                </p>

                @if($stats)
                    <div class="grid grid-cols-2 {{ $statColumns }} gap-px bg-white/10 border border-white/10 rounded-2xl overflow-hidden max-w-xl">
                        @foreach($stats as [$n, $l])
                            <div class="bg-stone-950/80 backdrop-blur px-4 py-3.5">
                                <div class="font-serif text-3xl text-white leading-none">{{ $n }}</div>
                                <div class="font-mono text-xs tracking-wide text-stone-400 mt-1.5">{{ $l }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-wrap gap-3 pt-1">
                    <a href="#projects"
                       class="inline-flex items-center gap-2 h-12 px-6 bg-linear-to-r from-violet-600 to-fuchsia-500 text-white text-sm font-medium rounded-full shadow-lg shadow-violet-600/30 hover:shadow-violet-500/50 hover:-translate-y-0.5 transition-all">
                        View Projects
                        <span aria-hidden="true">→</span>
                    </a>

                    @if($cvUrl)
                        <a href="{{ $cvUrl }}" target="_blank" rel="noopener"
                           class="inline-flex items-center h-12 px-6 bg-white text-stone-950 text-sm font-medium rounded-full hover:bg-violet-100 hover:-translate-y-0.5 transition-all">
                            Download CV
                        </a>
                    @endif

                    @if($github)
                        <a href="{{ $github }}" target="_blank" rel="noopener"
                           class="inline-flex items-center h-12 px-6 border border-white/20 text-white text-sm rounded-full hover:bg-white/10 transition-colors">
                            GitHub
                        </a>
                    @endif

                    @if($linkedin)
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener"
                           class="inline-flex items-center h-12 px-6 border border-white/20 text-white text-sm rounded-full hover:bg-white/10 transition-colors">
                            LinkedIn
                        </a>
                    @endif
                </div>

            </div>

            {{-- RIGHT SIDE (laptop and up): the floating project cards --}}
            <div class="hidden lg:block relative h-[560px]">

                <div id="workspace"
                    class="absolute inset-0 perspective-[1800px] xl:-translate-x-10">

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

            {{-- Phones and tablets: the same featured projects as a swipeable row --}}
            @if($featuredProjects->isNotEmpty())
                <div class="lg:hidden -mx-4 sm:-mx-6" aria-label="Featured projects">
                    <div class="flex gap-3 overflow-x-auto snap-x snap-mandatory px-4 sm:px-6 pb-3 [scrollbar-width:none]">
                        @foreach($featuredProjects as $project)
                            <a href="#projects"
                               class="snap-center shrink-0 w-[76%] sm:w-[44%] md:w-[34%] rounded-2xl border border-white/15 bg-white/[0.06] backdrop-blur p-4 hover:border-violet-300/50 transition-colors">
                                <h3 class="font-serif text-xl leading-tight text-white">{{ $project->title }}</h3>
                                <p class="font-mono text-xs uppercase tracking-wider text-stone-400 mt-2">{{ $project->category }}</p>
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    @foreach(array_slice($project->tech_tags ?? [], 0, 3) as $tag)
                                        <span class="text-xs px-2.5 py-1 rounded-full bg-violet-400/15 border border-violet-400/25 text-violet-200">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- Technology marquee (decorative: the same names are listed in Skills) --}}
        @if(! empty($marqueeSkills))
            <div class="marquee absolute bottom-0 inset-x-0 border-t border-white/10 bg-stone-950/70 backdrop-blur-md py-4 overflow-hidden" aria-hidden="true">
                <div class="marquee-track">
                    @foreach([1, 2] as $copy)
                        <div class="flex items-center shrink-0">
                            @foreach($marqueeSkills as $skillName)
                                <span class="font-mono text-[13px] uppercase tracking-[.18em] text-stone-400 px-6 flex items-center gap-6">
                                    {{ $skillName }}
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500/70"></span>
                                </span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- ABOUT                                                           --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    @if($about)
        <section id="about" class="max-w-6xl mx-auto px-4 sm:px-6 py-16 md:py-24">
            <div class="grid md:grid-cols-[1fr_2fr] gap-10 md:gap-16 items-start">
                <div class="md:sticky md:top-28">
                    <x-section-heading :number="$num('about')" label="About" title="A bit about me" class="!mb-0" />

                    @if($photo)
                        <img src="{{ $photo }}" alt="Photo of {{ $name }}" loading="lazy"
                             class="reveal mt-8 w-40 h-40 sm:w-48 sm:h-48 md:w-full md:max-w-[16rem] aspect-square object-cover rounded-3xl shadow-xl shadow-violet-900/10 ring-1 ring-stone-200">
                    @endif
                </div>

                <div class="space-y-5">
                    <p class="reveal font-serif text-2xl md:text-3xl leading-snug text-stone-900">{{ $about[0] }}</p>

                    @foreach(array_slice($about, 1) as $i => $paragraph)
                        <p class="reveal text-base md:text-[17px] text-stone-600 font-light leading-relaxed" style="--delay: {{ ($i + 1) * 90 }}ms">{{ $paragraph }}</p>
                    @endforeach

                    @if($location || $cvUrl)
                        <div class="reveal flex flex-wrap items-center gap-x-8 gap-y-2 pt-3 text-sm">
                            @if($location)
                                <span class="font-mono text-stone-500">📍 {{ $location }}</span>
                            @endif
                            @if($cvUrl)
                                <a href="{{ $cvUrl }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center min-h-11 font-medium text-violet-700 hover:text-violet-900 transition-colors">Download my CV →</a>
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
    <section id="projects" class="relative bg-stone-50 border-y border-stone-200/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16 md:py-24">
            <x-section-heading :number="$num('projects')" label="Work" title="Featured Projects">
                Tap any card for the details, tech breakdown, and links.
            </x-section-heading>

            @livewire('projects-grid')
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- CAREER TIMELINE (dark)                                          --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="experience" class="relative bg-stone-950 text-white overflow-hidden">
        <div class="absolute -top-40 right-0 w-[420px] md:w-[520px] h-[420px] md:h-[520px] bg-violet-600/20 blur-[140px] md:blur-[160px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 -left-32 w-[360px] md:w-[420px] h-[360px] md:h-[420px] bg-emerald-400/10 blur-[140px] md:blur-[150px] rounded-full pointer-events-none"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-16 md:py-24">
            <x-section-heading :number="$num('experience')" label="Career" title="Experience" :dark="true">
                Tap any role to see what I built there.
            </x-section-heading>

            @livewire('career-timeline')
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SKILLS                                                          --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="skills" class="max-w-6xl mx-auto px-4 sm:px-6 py-16 md:py-24">
        <x-section-heading :number="$num('skills')" label="Expertise" title="Technical Skills" />

        @livewire('skills-section')
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- CERTIFICATIONS                                                  --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="certifications" class="bg-stone-50 border-y border-stone-200/70">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16 md:py-24">
            <x-section-heading :number="$num('learning')" label="Learning" title="Certifications & Courses" />

            @livewire('certifications-section')
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- BLOG                                                            --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="blog" class="max-w-6xl mx-auto px-4 sm:px-6 py-16 md:py-24">
        <x-section-heading :number="$num('writing')" label="Writing" title="Dev Notes">
            Things I've learned, built, or debugged.
        </x-section-heading>

        @livewire('blog-section')
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- CONTACT (dark)                                                  --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section id="contact" class="relative bg-stone-950 text-white overflow-hidden">
        <div class="absolute -top-32 left-1/4 w-[460px] md:w-[620px] h-[460px] md:h-[620px] bg-violet-600/25 blur-[150px] md:blur-[170px] rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-40 right-0 w-[360px] md:w-[460px] h-[360px] md:h-[460px] bg-emerald-400/15 blur-[140px] md:blur-[160px] rounded-full pointer-events-none"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-16 md:py-24 grid lg:grid-cols-2 gap-12 lg:gap-16 items-start">
            <div class="reveal">
                <p class="font-mono text-xs tracking-[.25em] uppercase flex items-center gap-3 text-violet-300">
                    <span>{{ $num('contact') }}</span>
                    <span class="h-px w-8 bg-current opacity-40"></span>
                    <span>Get in touch</span>
                </p>
                <h2 class="font-serif text-5xl md:text-6xl leading-[.98] tracking-tight mt-3 mb-6">
                    Let's work <em class="text-gradient pr-2">together.</em>
                </h2>
                <p class="text-stone-400 text-base md:text-lg font-light leading-relaxed mb-8 max-w-md">
                    Open to full-time roles, freelance contracts, and interesting side projects.
                    @if($location) Based in {{ $location }} — @endif available remotely worldwide.
                </p>
                <div class="space-y-3 text-stone-300">
                    @if($email)
                        <a href="mailto:{{ $email }}" class="group flex items-center gap-4 min-h-12 hover:text-white transition-colors">
                            <span class="w-11 h-11 shrink-0 rounded-full border border-white/15 flex items-center justify-center text-stone-400 group-hover:border-violet-400 group-hover:text-violet-300 transition-colors" aria-hidden="true">✉</span>
                            <span class="min-w-0 break-words">{{ $email }}</span>
                        </a>
                    @endif
                    @if($phone)
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="group flex items-center gap-4 min-h-12 hover:text-white transition-colors">
                            <span class="w-11 h-11 shrink-0 rounded-full border border-white/15 flex items-center justify-center text-stone-400 group-hover:border-violet-400 group-hover:text-violet-300 transition-colors" aria-hidden="true">☎</span>
                            <span class="min-w-0 break-words">{{ $phone }}</span>
                        </a>
                    @endif
                    @if($linkedin)
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener" class="group flex items-center gap-4 min-h-12 hover:text-white transition-colors">
                            <span class="w-11 h-11 shrink-0 rounded-full border border-white/15 flex items-center justify-center text-xs font-medium text-stone-400 group-hover:border-violet-400 group-hover:text-violet-300 transition-colors" aria-hidden="true">in</span>
                            <span class="min-w-0 break-all">{{ $display($linkedin) }}</span>
                        </a>
                    @endif
                    @if($github)
                        <a href="{{ $github }}" target="_blank" rel="noopener" class="group flex items-center gap-4 min-h-12 hover:text-white transition-colors">
                            <span class="w-11 h-11 shrink-0 rounded-full border border-white/15 flex items-center justify-center text-stone-400 group-hover:border-violet-400 group-hover:text-violet-300 transition-colors" aria-hidden="true">⌥</span>
                            <span class="min-w-0 break-all">{{ $display($github) }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <div class="reveal rounded-3xl border border-white/10 bg-white/[0.04] backdrop-blur p-5 sm:p-8" style="--delay: 120ms">
                @livewire('contact-form')
            </div>
        </div>
    </section>

</x-layouts.app>
