<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;

class AchievementService
{
    public static function unlock(User $user, string $name)
    {
        Achievement::firstOrCreate([
            'user_id' => $user->id,
            'name' => $name,
        ]);
    }
}
