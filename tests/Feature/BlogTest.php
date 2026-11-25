<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    private function makePost(array $overrides = []): BlogPost
    {
        return BlogPost::create(array_merge([
            'title'        => 'Debugging a VPN tunnel',
            'slug'         => 'debugging-a-vpn-tunnel',
            'excerpt'      => 'How I got StrongSwan talking to a partner API.',
            'body'         => '<p>Hello <strong>world</strong></p>',
            'tags'         => ['AWS', 'Networking'],
            'is_published' => true,
            'published_at' => now()->subDay(),
        ], $overrides));
    }

    public function test_blog_index_lists_published_posts_only(): void
    {
        $this->makePost();
        $this->makePost(['title' => 'Secret draft', 'slug' => 'secret-draft', 'is_published' => false]);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('Debugging a VPN tunnel')
            ->assertDontSee('Secret draft');
    }

    public function test_blog_index_shows_empty_state(): void
    {
        $this->get('/blog')->assertOk()->assertSee('No posts yet');
    }

    public function test_blog_post_page_renders_body_and_title(): void
    {
        $this->makePost();

        $this->get('/blog/debugging-a-vpn-tunnel')
            ->assertOk()
            ->assertSee('<strong>world</strong>', false)
            ->assertSee('<title>Debugging a VPN tunnel — Muhammad Ahmed</title>', false);
    }

    public function test_unpublished_post_returns_404(): void
    {
        $this->makePost(['slug' => 'draft', 'is_published' => false]);

        $this->get('/blog/draft')->assertNotFound();
    }
}
