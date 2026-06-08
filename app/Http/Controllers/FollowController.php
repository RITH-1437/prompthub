<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowController extends Controller
{
    public function store(User $user)
    {
        $changes = auth()->user()
            ->following()
            ->syncWithoutDetaching([$user->id]);

        if (!empty($changes['attached'])) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'message' => auth()->user()->name . ' just following you.'
            ]);
        }

        return back();
    }

    public function destroy(User $user)
    {
        auth()->user()
            ->following()
            ->detach($user->id);

        \App\Models\Notification::create([
            'user_id' => $user->id,
                'message' => auth()->user()->name . ' just unfollow you.'
        ]);

        return back();
    }
}
