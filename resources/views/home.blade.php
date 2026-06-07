<x-layouts.app>

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

                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-200 rounded-full text-xs text-emerald-700">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                    Open to opportunities · Lahore, Pakistan
                </div>

                <div>
                    <p class="text-sm font-light text-stone-400 tracking-widest uppercase mb-2">
                        Backend Developer
                    </p>

                    <h1 class="font-serif text-6xl md:text-7xl leading-none text-stone-900">
                        Muhammad<br>
                        <em class="not-italic text-violet-600">Ahmed</em>
                    </h1>
                </div>

                <p class="text-stone-500 font-light leading-relaxed max-w-md">
                    3+ years building full-stack web applications — trading LMS platforms,
                    multi-vendor e-commerce, live sports feeds, and AI-powered tools.
                    Specialist in Laravel, Livewire & real-time systems.
                </p>

                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-violet-200 bg-violet-50 text-xs text-violet-700">
                    <span class="w-2 h-2 bg-violet-500 rounded-full animate-pulse"></span>
                    <!-- Currently building AI-powered workout platform -->
                    Currently building AI-powered platform
                </div>

                <div class="flex gap-8 pt-2">
                    @foreach([
                        ['3+','Years'],
                        ['10+','Projects'],
                        ['25k+','Notifications'],
                        ['1+','Production Apps']
                    ] as [$n,$l])
                        <div>
                            <div class="font-serif text-2xl text-stone-900">{{ $n }}</div>
                            <div class="text-xs text-stone-400 mt-0.5">{{ $l }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <a href="#projects"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-violet-600 text-white text-sm rounded-full hover:bg-violet-700">
                        View Projects
                    </a>

                    <a href="https://github.com/masix04"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 border border-violet-200 text-violet-700 rounded-full hover:bg-violet-50">
                        GitHub
                    </a>

                    <a href="https://www.linkedin.com/in/muhammad-ahmed-61b21b163/"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 border border-emerald-200 text-emerald-700 rounded-full hover:bg-emerald-50">
                        LinkedIn
                    </a>
                </div>

            </div>

            {{-- RIGHT SIDE --}}
            <div class="hidden lg:block relative h-[600px]">

                <div id="workspace"
                    class="absolute inset-0 perspective-[1800px]">

                    <div id="workspace-inner"
                        class="relative w-full h-full transform-gpu">

                        @foreach($featuredProjects as $project)
                            <div class="workspace-card absolute {{ $project->top_class }} {{ $project->left_class }}"
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
                    Based in Lahore — available remotely worldwide.
                </p>
                <div class="space-y-3 text-sm text-stone-400">
                    <a href="mailto:muhammadahmed5867@gmail.com" class="flex items-center gap-3 hover:text-white transition-colors">
                        <span class="text-stone-600">✉</span> muhammadahmed5867@gmail.com
                    </a>
                    <a href="tel:+923328426292" class="flex items-center gap-3 hover:text-white transition-colors">
                        <span class="text-stone-600">☎</span> +92 332 8426292
                    </a>
                    <a href="https://www.linkedin.com/in/muhammad-ahmed-61b21b163/" target="_blank" class="flex items-center gap-3 hover:text-white transition-colors">
                        <span class="text-stone-600">in</span> linkedin.com/in/muhammad-ahmed
                    </a>
                    <a href="https://github.com/masix04" target="_blank" class="flex items-center gap-3 hover:text-white transition-colors">
                        <span class="text-stone-600">⌥</span> github.com/masix04
                    </a>
                </div>
            </div>
            <div>
                @livewire('contact-form')
            </div>
        </div>
    </section>

</x-layouts.app>
