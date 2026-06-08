<?php

namespace App\Http\Controllers;

use App\Models\Prompt;

class CopyController extends Controller
{
    public function store(Prompt $prompt)
    {
        $prompt->increment('copy_count');

        return response()->json([
            'success' => true,
        ]);
    }
}
