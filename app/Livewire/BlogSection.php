<?php

use Livewire\Component;

use App\Models\BlogPost;

class BlogSection extends Component
{
    public function render()
    {
        return view('livewire.blog-section', [
            'posts' => \App\Models\BlogPost::published()->latest3()->get(),
        ]);
    }
}