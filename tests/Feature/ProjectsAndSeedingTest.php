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
