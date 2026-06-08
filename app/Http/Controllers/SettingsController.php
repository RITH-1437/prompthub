<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('settings.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(
                    $request->user()->id
                ),
            ],
            'bio' => 'nullable|string|max:500',
            'avatar' => [
                'exclude_with:avatar_file',
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (! $value) {
                        return;
                    }

                    if (str_starts_with($value, '/storage/')) {
                        return;
                    }

                    if (str_starts_with($value, 'data:image/')) {
                        if (
                            ! preg_match(
                                '/^data:image\/([a-zA-Z0-9.+-]+);base64,(.+)$/s',
                                $value,
                                $matches
                            )
                        ) {
                            $fail('Avatar must be a valid URL or an uploaded image path.');

                            return;
                        }

                        $decoded = base64_decode($matches[2], true);

                        if ($decoded === false) {
                            $fail('Avatar must be a valid URL or an uploaded image path.');

                            return;
                        }

                        if (strlen($decoded) > 2048 * 1024) {
                            $fail('Avatar image must not be greater than 2048 KB.');
                        }

                        return;
                    }

                    if (filter_var($value, FILTER_VALIDATE_URL)) {
                        if (strlen($value) > 4096) {
                            $fail('Avatar URL must not be greater than 4096 characters.');
                        }

                        return;
                    }

                    $fail('Avatar must be a valid URL or an uploaded image path.');
                },
            ],
            'avatar_file' => 'nullable|image|max:2048',
        ]);

        $avatarUrl = $request->has('avatar') ? $request->avatar : $request->user()->avatar;

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $avatarUrl = Storage::url($path);
        } elseif ($avatarUrl && str_starts_with($avatarUrl, 'data:image/')) {
            preg_match(
                '/^data:image\/([a-zA-Z0-9.+-]+);base64,(.+)$/s',
                $avatarUrl,
                $matches
            );

            $extension = strtolower($matches[1]);
            $decoded = base64_decode($matches[2], true);
            $fileName = 'avatars/'.Str::uuid().'.'.$extension;

            if (! Storage::disk('public')->put($fileName, $decoded)) {
                return back()->withErrors([
                    'avatar' => 'Avatar image could not be saved.',
                ]);
            }

            $avatarUrl = Storage::url($fileName);
        }

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
            'avatar' => $avatarUrl,
        ]);

        return back()->with(
            'status',
            'profile-updated'
        )->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [], 'updatePassword');

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with(
            'status',
            'password-updated'
        );
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [], 'userDeletion');

        $user = $request->user();
        auth()->logout();
        $user->delete();

        return redirect('/')->with(
            'success',
            'Account deleted successfully.'
        );
    }
}
