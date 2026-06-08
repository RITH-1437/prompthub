<?php

namespace App\Http\Controllers;

use App\Models\Prompt;

class ExploreController extends Controller
{
    public function index()
    {
        $search = request('search');

        $prompts = Prompt::query()

            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('prompt_content', 'like', "%{$search}%");
            })

            ->latest()
            ->get();

        return view('explore.index', [
            'prompts' => $prompts,
            'search' => $search,
        ]);
    }
}
