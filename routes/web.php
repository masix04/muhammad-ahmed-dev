<?php

use Illuminate\Support\Facades\Route;
use App\Models\BlogPost;

Route::get('/', fn() => view('home'));

// Blog list
Route::get('/blog', function () {
    $posts = BlogPost::published()->orderByDesc('published_at')->paginate(9);
    return view('blog.index', compact('posts'));
});

// Blog single post
Route::get('/blog/{slug}', function (string $slug) {
    $post = BlogPost::where('slug', $slug)->where('is_published', true)->firstOrFail();
    return view('blog.show', compact('post'));
});

// robots.txt — served from here so it can point at this site's own sitemap URL.
Route::get('/robots.txt', function () {
    $body = "User-agent: *\nDisallow: /admin\n\nSitemap: " . url('/sitemap.xml') . "\n";

    return response($body, 200, ['Content-Type' => 'text/plain']);
});

// sitemap.xml — the home page, the blog list and every published post.
Route::get('/sitemap.xml', function () {
    $posts = BlogPost::published()->orderByDesc('published_at')->get(['slug', 'published_at', 'updated_at']);

    return response()
        ->view('sitemap', ['posts' => $posts])
        ->header('Content-Type', 'application/xml');
});
