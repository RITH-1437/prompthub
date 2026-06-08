<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::with('prompts')
            ->get()
            ->map(function ($user) {

                $views = $user->prompts->sum('views_count');

                $copies = $user->prompts->sum('copy_count');

                $user->views_total = $views;

                $user->copies_total = $copies;

                $user->score = $views + $copies;

                return $user;

            })
            ->sortByDesc('score');

        return view('leaderboard.index', compact('users'));
    }
}
