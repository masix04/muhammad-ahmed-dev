<?php

namespace Tests\Feature;

use App\Livewire\CareerTimeline;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\WorkExperience;
use App\Support\Gradient;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DesignTest extends TestCase
{
    use RefreshDatabase;

    /** The numbers shown in the section labels ("01 — About" …), in page order. */
    private function sectionNumbers(): array
    {
        preg_match_all('#<span>(\d{2})</span>#', $this->get('/')->getContent(), $m);

        return $m[1];
    }

    // ── Page structure ──────────────────────────────────────────────────────

    public function test_section_numbers_count_up_without_gaps(): void
    {
        // No About text: Projects is first.
        $this->assertSame(['01', '02', '03', '04', '05', '06'], $this->sectionNumbers());

        SiteSetting::set('about_text', 'Hello there.');

        $this->assertSame(['01', '02', '03', '04', '05', '06', '07'], $this->sectionNumbers());
    }

    public function test_pages_with_a_dark_top_start_the_nav_light_on_dark(): void
    {
        $this->get('/')->assertSee('heroDark: true', false);
        $this->get('/blog')->assertSee('heroDark: true', false);
    }

    public function test_the_menu_button_is_for_phones_and_tablets_and_the_links_start_at_laptop_width(): void
    {
        $html = $this->get('/')->getContent();

        // The menu button is hidden from "lg" (laptops) up, so phones AND tablets get it.
        $this->assertStringContainsString('lg:hidden', $html);
        // The in-bar links only appear from "lg".
        $this->assertStringContainsString('hidden lg:flex items-center gap-7', $html);
    }

    public function test_nav_links_can_be_tracked_while_scrolling_and_each_points_at_a_real_section(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertStringContainsString('class="nav-underline"', $html);

        // Every desktop link carries the scroll-spy marker and targets a section on the page.
        preg_match_all('/<a href="\/#(\w+)"\s+data-spy-link/', $html, $m);
        $this->assertGreaterThanOrEqual(5, count($m[1]));
        foreach ($m[1] as $id) {
            $this->assertStringContainsString('id="'.$id.'"', $html, "No section with id {$id}");
        }
    }

    public function test_scroll_reveal_only_hides_content_when_javascript_runs(): void
    {
        // The "js" class is added by a script in the head; the CSS only hides .reveal under it.
        $this->get('/')
            ->assertSee("document.documentElement.classList.add('js')", false)
            ->assertSee('reveal', false);
    }

    // ── Hero slider ─────────────────────────────────────────────────────────

    public function test_hero_slider_shows_only_published_featured_projects_in_admin_order(): void
    {
        Project::create(['title' => 'Second One', 'slug' => 's2', 'short_description' => 'x', 'is_featured' => true, 'is_published' => true, 'sort_order' => 2]);
        Project::create(['title' => 'First One', 'slug' => 's1', 'short_description' => 'x', 'is_featured' => true, 'is_published' => true, 'sort_order' => 1]);
        Project::create(['title' => 'Hidden Featured', 'slug' => 'hf', 'short_description' => 'x', 'is_featured' => true, 'is_published' => false]);

        $html = $this->get('/')->assertOk()->getContent();

        // The floating cards (laptop and up).
        preg_match_all('#<div class="workspace-card[^>]*>\s*<h3>(.*?)</h3>#s', $html, $m);
        $this->assertSame(['First One', 'Second One'], $m[1]);
    }

    public function test_phones_and_tablets_get_the_same_projects_as_a_swipeable_row(): void
    {
        Project::create(['title' => 'Row Project', 'slug' => 'rp', 'short_description' => 'x', 'is_featured' => true, 'is_published' => true]);

        $this->get('/')
            ->assertSee('snap-x snap-mandatory', false)
            ->assertSee('aria-label="Featured projects"', false);
    }

    public function test_the_seeded_hero_has_five_featured_projects_including_the_personal_ones(): void
    {
        $this->seed(DatabaseSeeder::class);

        $featured = Project::published()->featured()->ordered()->pluck('title')->all();

        $this->assertCount(5, $featured);
        $this->assertContains('Stock Assistant', $featured);
        $this->assertContains('Web Portal Platform', $featured);

        // Added to the portfolio, but not one of the five hero cards.
        $log = Project::where('slug', 'daily-routine-log')->first();
        $this->assertNotNull($log);
        $this->assertFalse($log->is_featured);
    }

    public function test_the_generic_work_project_never_names_games_or_partners(): void
    {
        $this->seed(DatabaseSeeder::class);

        $project = Project::where('slug', 'web-portal-platform')->firstOrFail();

        $text = strtolower(json_encode($project->only([
            'title', 'short_description', 'full_description', 'my_role', 'challenge', 'solution', 'outcome', 'tech_tags',
        ])));

        foreach (['game', 'gaming', 'casino', 'partner', 'fintech', 'finz'] as $forbidden) {
            $this->assertStringNotContainsString($forbidden, $text, "Generic project must not mention \"{$forbidden}\"");
        }
    }

    // ── Career: more than one time period ───────────────────────────────────

    public function test_a_role_can_list_several_time_periods(): void
    {
        $role = WorkExperience::create([
            'role' => 'Freelance Developer', 'company' => 'Independent', 'period' => 'Feb 2026 – Jun 2026',
            'start_date' => '2026-02-01',
            'additional_periods' => [['period' => 'Nov 2026 – Present'], ['period' => '  '], ['period' => 'Mar 2027']],
        ]);

        // Main period first; blank ones are skipped.
        $this->assertSame(['Feb 2026 – Jun 2026', 'Nov 2026 – Present', 'Mar 2027'], $role->allPeriods());

        Livewire::test(CareerTimeline::class)
            ->assertSeeInOrder(['Feb 2026 – Jun 2026', 'Nov 2026 – Present', 'Mar 2027', 'Freelance Developer']);
    }

    public function test_a_role_without_extra_periods_shows_just_the_main_one(): void
    {
        $role = WorkExperience::create([
            'role' => 'Engineer', 'company' => 'Acme', 'period' => '2024 – 2025', 'start_date' => '2024-01-01',
        ]);

        $this->assertSame(['2024 – 2025'], $role->allPeriods());
    }

    // ── Gradient fallback ───────────────────────────────────────────────────

    public function test_gradient_is_stable_for_the_same_title_and_always_a_known_one(): void
    {
        $this->assertSame(Gradient::for('TeachersLink'), Gradient::for('TeachersLink'));
        $this->assertStringStartsWith('from-', Gradient::for('Anything at all'));
        $this->assertStringStartsWith('from-', Gradient::for(null));
    }

    public function test_gradient_initials_use_the_first_two_words(): void
    {
        $this->assertSame('FK', Gradient::initials('Forex/Kleos/ILMU'));
        $this->assertSame('MT', Gradient::initials('Multi-Tenant E-commerce'));
        $this->assertSame('TS', Gradient::initials('TeachersLink School LMS'));
        $this->assertSame('BO', Gradient::initials('Boilerplate'));
        $this->assertSame('', Gradient::initials(''));
        $this->assertSame('ÄÖ', Gradient::initials('Ärger Önsker'));
    }
}
