<?php

namespace App\Http\Controllers;

use App\Models\Prompt;

class AdminPromptController extends Controller
{
    public function index()
    {
        $prompts = Prompt::with('user')->latest()->get();

        return view('admin.prompts.index', compact('prompts'));
    }

    public function toggleFeature(Prompt $prompt)
    {
        $prompt->update([
            'is_featured' => ! $prompt->is_featured,
        ]);

        return back();
    }

    public function destroy(Prompt $prompt)
    {
        $prompt->delete();

        return back();
    }
}
