<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $prompts = $tag->prompts()->latest()->get();

        return view('tags.show', compact('tag', 'prompts'));
    }
}
