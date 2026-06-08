<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $period = $request->input('period', 'all'); // 'all', '30', '7'

        // Base query for prompts within the selected period
        $promptsQuery = $user->prompts()->when($period !== 'all', function ($query) use ($period) {
            $query->where('created_at', '>=', Carbon::now()->subDays((int)$period));
        });

        // Get IDs for further queries
        $promptIds = (clone $promptsQuery)->pluck('id');

        // Calculate stats
        $totalViews = (clone $promptsQuery)->sum('views_count');
        $totalCopies = (clone $promptsQuery)->sum('copy_count');
        $totalPrompts = $promptIds->count();
        $totalFavorites = \App\Models\Favorite::whereIn('prompt_id', $promptIds)->count();

        // Get top performing prompts within the period
        $topPrompts = (clone $promptsQuery)
            ->withAvg('ratings', 'rating') // Eager load average rating
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        return view(
            'analytics.index',
            compact(
                'totalViews',
                'totalCopies',
                'totalFavorites',
                'totalPrompts',
                'topPrompts',
                'period'
            )
        );
    }
}
