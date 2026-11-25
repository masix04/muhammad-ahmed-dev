<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\SiteSetting;
use Database\Seeders\SiteSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_has_share_tags_and_structured_data(): void
    {
        $this->seed(SiteSettingsSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('<meta property="og:title"', false)
            ->assertSee('<meta property="og:type" content="website">', false)
            ->assertSee('<meta name="twitter:card" content="summary">', false)
            ->assertSee('<link rel="canonical"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('"@type":"Person"', false)
            ->assertSee('https://github.com/masix04', false)
            // No share image has been configured, so none must be advertised.
            ->assertDontSee('og:image', false);
    }

    public function test_share_image_makes_the_twitter_card_large(): void
    {
        SiteSetting::set('og_image', 'images/share.png');

        $this->get('/')
            ->assertSee('<meta name="twitter:card" content="summary_large_image">', false)
            ->assertSee('<meta property="og:image" content="' . url('images/share.png') . '">', false);
    }

    public function test_about_section_shows_only_when_there_is_text(): void
    {
        $this->get('/')->assertDontSee('id="about"', false);

        SiteSetting::set('about_text', "First paragraph.\n\nSecond paragraph.");

        $this->get('/')
            ->assertSee('id="about"', false)
            ->assertSee('First paragraph.')
            ->assertSee('Second paragraph.');
    }

    public function test_cv_button_shows_only_when_a_cv_is_set(): void
    {
        $this->get('/')->assertDontSee('Download CV');

        SiteSetting::set('cv_url', 'cv/muhammad-ahmed.pdf');

        $this->get('/')
            ->assertSee('Download CV')
            ->assertSee(url('cv/muhammad-ahmed.pdf'), false);
    }

    public function test_hero_stats_and_contact_details_come_from_settings(): void
    {
        SiteSetting::set('hero_stats', "9+ | Gadgets\nnot a stat line");
        SiteSetting::set('email', 'hello@example.test');
        SiteSetting::set('phone', '+1 (555) 010-0000');

        $this->get('/')
            ->assertSee('9+')
            ->assertSee('Gadgets')
            ->assertDontSee('not a stat line')
            ->assertSee('mailto:hello@example.test', false)
            ->assertSee('tel:+15550100000', false);
    }

    public function test_changing_a_setting_is_picked_up_in_the_same_request_cycle(): void
    {
        SiteSetting::set('location', 'Karachi, Pakistan');
        $this->assertSame('Karachi, Pakistan', SiteSetting::get('location'));

        SiteSetting::set('location', 'Islamabad, Pakistan');
        $this->assertSame('Islamabad, Pakistan', SiteSetting::get('location'));
    }

    public function test_settings_seeder_keeps_values_edited_in_the_admin(): void
    {
        SiteSetting::set('hero_title', 'Edited title');

        $this->seed(SiteSettingsSeeder::class);

        $this->assertSame('Edited title', SiteSetting::get('hero_title'));
        $this->assertNotNull(SiteSetting::get('about_text'));
    }

    public function test_blog_post_is_marked_as_an_article(): void
    {
        BlogPost::create([
            'title' => 'Hello', 'slug' => 'hello', 'body' => '<p>Hi</p>',
            'is_published' => true, 'published_at' => now()->subDay(),
        ]);

        $this->get('/blog/hello')
            ->assertSee('<meta property="og:type" content="article">', false)
            ->assertSee('article:published_time', false);
    }

    public function test_robots_txt_points_to_the_sitemap_and_hides_the_admin(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: ' . url('/sitemap.xml'), false);
    }

    public function test_sitemap_lists_published_posts_only(): void
    {
        BlogPost::create(['title' => 'Live', 'slug' => 'live', 'body' => 'x', 'is_published' => true, 'published_at' => now()]);
        BlogPost::create(['title' => 'Draft', 'slug' => 'draft', 'body' => 'x', 'is_published' => false]);

        $response = $this->get('/sitemap.xml')->assertOk();

        $response->assertSee(url('/blog/live'), false)
            ->assertDontSee(url('/blog/draft'), false);
        $this->assertStringContainsString('application/xml', $response->headers->get('Content-Type'));
        $this->assertStringStartsWith('<?xml', $response->getContent());
    }
}
