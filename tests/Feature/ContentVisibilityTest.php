<?php

namespace Tests\Feature;

use App\Livewire\CareerTimeline;
use App\Livewire\CertificationsSection;
use App\Livewire\SkillsSection;
use App\Models\BlogPost;
use App\Models\Certification;
use App\Models\Project;
use App\Models\Skill;
use App\Models\WorkExperience;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContentVisibilityTest extends TestCase
{
    use RefreshDatabase;

    // ── Skills ──────────────────────────────────────────────────────────────

    public function test_hidden_skills_are_not_shown(): void
    {
        Skill::create(['name' => 'Laravel', 'category' => 'Backend', 'is_visible' => true]);
        Skill::create(['name' => 'Secret Tool', 'category' => 'Backend', 'is_visible' => false]);

        Livewire::test(SkillsSection::class)
            ->assertSee('Laravel')
            ->assertDontSee('Secret Tool');
    }

    public function test_skills_follow_category_then_sort_order(): void
    {
        Skill::create(['name' => 'Zeta', 'category' => 'Backend', 'sort_order' => 1]);
        Skill::create(['name' => 'Alpha', 'category' => 'Backend', 'sort_order' => 2]);

        Livewire::test(SkillsSection::class)->assertSeeInOrder(['Zeta', 'Alpha']);
    }

    public function test_skills_can_be_filtered_by_category(): void
    {
        Skill::create(['name' => 'Laravel', 'category' => 'Backend']);
        Skill::create(['name' => 'Tailwind CSS', 'category' => 'Frontend']);

        Livewire::test(SkillsSection::class)
            ->set('activeCategory', 'Frontend')
            ->assertSee('Tailwind CSS')
            ->assertDontSee('Laravel');
    }

    // ── Blog scheduling ─────────────────────────────────────────────────────

    private function makePost(string $slug, array $overrides = []): BlogPost
    {
        return BlogPost::create(array_merge([
            'title' => "Post {$slug}", 'slug' => $slug, 'body' => '<p>x</p>',
            'is_published' => true, 'published_at' => now()->subDay(),
        ], $overrides));
    }

    public function test_a_post_dated_in_the_future_stays_hidden_until_then(): void
    {
        $this->makePost('later', ['published_at' => now()->addDays(3)]);

        $this->get('/blog')->assertDontSee('Post later');
        $this->get('/blog/later')->assertNotFound();
        $this->get('/sitemap.xml')->assertDontSee('/blog/later', false);

        $this->travel(4)->days();

        $this->get('/blog')->assertSee('Post later');
        $this->get('/blog/later')->assertOk();
        $this->get('/sitemap.xml')->assertSee('/blog/later', false);
    }

    public function test_a_published_post_without_a_date_is_still_visible(): void
    {
        $this->makePost('undated', ['published_at' => null]);

        $this->get('/blog/undated')->assertOk();
    }

    public function test_an_unpublished_post_stays_hidden_even_with_a_past_date(): void
    {
        $this->makePost('off', ['is_published' => false]);

        $this->get('/blog/off')->assertNotFound();
    }

    // ── Fields that used to be saved but never shown ────────────────────────

    public function test_company_link_shows_in_the_open_timeline_entry_when_set(): void
    {
        WorkExperience::create([
            'role' => 'Engineer', 'company' => 'Acme Ltd', 'period' => '2024 – Present',
            'start_date' => '2024-01-01', 'is_current' => true, 'company_url' => 'https://acme.example',
        ]);

        // The newest entry opens automatically.
        Livewire::test(CareerTimeline::class)
            ->assertSeeHtml('href="https://acme.example"')
            ->assertSee('Visit Acme Ltd');
    }

    public function test_no_company_link_when_none_is_set(): void
    {
        WorkExperience::create([
            'role' => 'Engineer', 'company' => 'Acme Ltd', 'period' => '2024 – Present',
            'start_date' => '2024-01-01', 'is_current' => true,
        ]);

        Livewire::test(CareerTimeline::class)->assertDontSee('Visit Acme Ltd');
    }

    public function test_certificate_image_replaces_the_icon_when_set(): void
    {
        Certification::create(['title' => 'With image', 'issuer' => 'X', 'certificate_image' => 'certs/a.png', 'is_visible' => true]);
        Certification::create(['title' => 'No image', 'issuer' => 'Y', 'is_visible' => true]);

        Livewire::test(CertificationsSection::class)
            ->assertSeeHtml('alt="Certificate: With image"')
            ->assertDontSeeHtml('alt="Certificate: No image"')
            ->assertSee('No image');
    }

    // ── Hero cards ──────────────────────────────────────────────────────────

    public function test_featured_projects_without_a_saved_position_get_one_automatically(): void
    {
        // forceCreate: like the seeder, which runs with mass-assignment protection off.
        Project::forceCreate(['title' => 'Placed', 'slug' => 'placed', 'short_description' => 'a', 'is_featured' => true,
            'is_published' => true, 'top_class' => 'top-[10%]', 'left_class' => 'left-[55%]']);
        Project::create(['title' => 'Unplaced', 'slug' => 'unplaced', 'short_description' => 'b', 'is_featured' => true,
            'is_published' => true]);

        $html = $this->get('/')->assertOk()->getContent();

        // The saved position is used as before, with no inline style on that card.
        $this->assertStringContainsString('workspace-card absolute top-[10%] left-[55%]', $html);
        // The other one gets an inline position instead of landing in the corner.
        $this->assertSame(1, preg_match_all('/<div class="workspace-card absolute\s+"\s+style="top: \d+%; left: \d+%"/', $html));
    }
}
