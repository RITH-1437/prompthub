<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalPrompts = $user->prompts()->count();

        $totalFavorites = $user->favorites()->count();

        $totalFollowers = $user->followers()->count();

        $totalChats = \App\Models\Conversation::count();

        $recentPrompts = $user->prompts()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalPrompts',
            'totalFavorites',
            'totalFollowers',
            'totalChats',
            'recentPrompts'
        ));
    }
}
