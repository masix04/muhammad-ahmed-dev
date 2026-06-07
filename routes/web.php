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
