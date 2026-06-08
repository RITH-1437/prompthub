<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function grantAdmin(User $user)
    {
        $user->update([
            'is_admin' => true,
        ]);

        return back();
    }

    public function revokeAdmin(User $user)
    {
        $user->update([
            'is_admin' => false,
        ]);

        return back();
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back();
        }

        $user->delete();

        return back();
    }
}
