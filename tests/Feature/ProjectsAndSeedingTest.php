<?php

namespace Tests\Feature;

use App\Livewire\ProjectsGrid;
use App\Models\Project;
use App\Models\SiteSetting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectsAndSeedingTest extends TestCase
{
    use RefreshDatabase;

    private function project(array $overrides = []): Project
    {
        return Project::create(array_merge([
            'title'             => 'Multi-tenant shop',
            'slug'              => 'multi-tenant-shop',
            'short_description' => 'A marketplace.',
            'tech_tags'         => ['Laravel', 'Stripe'],
            'is_published'      => true,
        ], $overrides));
    }

    public function test_projects_can_be_filtered_by_tag_and_opened(): void
    {
        $this->project();
        $this->project(['title' => 'Sports feed', 'slug' => 'sports-feed', 'tech_tags' => ['Socket.io']]);

        Livewire::test(ProjectsGrid::class)
            ->assertSee('Multi-tenant shop')
            ->assertSee('Sports feed')
            ->call('filterBy', 'Socket.io')
            ->assertDontSee('Multi-tenant shop')
            ->assertSee('Sports feed')
            ->call('openModal', Project::where('slug', 'sports-feed')->value('id'))
            ->assertSeeHtml('role="dialog"')
            ->call('closeModal')
            ->assertDontSeeHtml('role="dialog"');
    }

    public function test_case_study_shows_in_the_popup_only_for_the_parts_that_are_filled(): void
    {
        $project = $this->project([
            'my_role'   => 'Backend developer in a team of 4',
            'challenge' => 'Schools had no single place for timetables.',
            'solution'  => 'A Laravel API plus a Livewire dashboard.',
            // no outcome on purpose: nothing should be invented for it
        ]);

        Livewire::test(ProjectsGrid::class)
            ->call('openModal', $project->id)
            ->assertSee('My role:')
            ->assertSee('Backend developer in a team of 4')
            ->assertSee('The problem')
            ->assertSee('Schools had no single place for timetables.')
            ->assertSee('What I built')
            ->assertDontSee('The result');
    }

    public function test_popup_without_case_study_fields_has_no_empty_boxes(): void
    {
        $project = $this->project();

        Livewire::test(ProjectsGrid::class)
            ->call('openModal', $project->id)
            ->assertSee('A marketplace.')
            ->assertDontSee('My role:')
            ->assertDontSee('The problem')
            ->assertDontSee('What I built');
    }

    public function test_case_study_text_is_escaped(): void
    {
        $project = $this->project(['challenge' => '<script>alert(1)</script>']);

        Livewire::test(ProjectsGrid::class)
            ->call('openModal', $project->id)
            ->assertDontSeeHtml('<script>alert(1)</script>')
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    public function test_unpublished_projects_are_hidden(): void
    {
        $this->project(['title' => 'Secret project', 'slug' => 'secret', 'is_published' => false]);

        Livewire::test(ProjectsGrid::class)->assertDontSee('Secret project');
    }

    public function test_seeding_a_new_database_fills_it(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertGreaterThan(0, Project::count());
        $this->assertNotNull(SiteSetting::get('hero_title'));
    }

    public function test_seeding_again_keeps_content_edited_in_the_admin(): void
    {
        $this->seed(DatabaseSeeder::class);

        Project::query()->first()->update(['title' => 'Edited in admin']);
        Project::query()->where('title', '!=', 'Edited in admin')->delete();
        SiteSetting::set('hero_title', 'My own title');

        // This is what happens on every container restart.
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(['Edited in admin'], Project::pluck('title')->all());
        $this->assertSame('My own title', SiteSetting::get('hero_title'));
    }
}
