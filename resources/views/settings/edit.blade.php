@extends('layouts.app')

@section('content')
@php $user = auth()->user(); @endphp

<div class="max-w-5xl mx-auto space-y-8 pb-12 font-sans">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-violet-600 flex items-center justify-center shadow-lg shadow-blue-500/20 text-white text-3xl font-bold uppercase overflow-hidden border border-white/10">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($user->name, 0, 1) }}
                    @endif
                </div>
                <div>
                    <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">Account Settings</h1>
                    <p class="text-slate-400 text-sm max-w-xl">Manage your profile, password, and account access.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('profile.index') }}" class="bg-slate-800 hover:bg-slate-700 text-white font-semibold px-5 py-2.5 rounded-xl border border-slate-600 transition-colors flex items-center justify-center gap-2 shadow-lg shadow-black/20">
                    <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                    Profile
                </a>
                <a href="{{ route('users.show', $user) }}" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 border border-blue-500/50">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                    Public Profile
                </a>
            </div>
        </div>

        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-violet-500/10 blur-3xl"></div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 px-4 py-3 rounded-2xl flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-2xl flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-[1fr_20rem] gap-8">
        <div class="space-y-8">
            <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                    <i data-lucide="id-card" class="w-6 h-6 text-blue-400"></i>
                    Profile Information
                </h2>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-slate-300">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required autocomplete="name" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors">
                            @error('name') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-slate-300">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors">
                            @error('email') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="avatar-url" class="block mb-2 text-sm font-medium text-slate-300">Avatar</label>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                            <div class="w-20 h-20 rounded-full bg-slate-800 border border-slate-700 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="user" class="w-8 h-8 text-slate-500"></i>
                                @endif
                            </div>

                            <div class="flex-1">
                                <input type="text" name="avatar" id="avatar-url" value="{{ old('avatar', $user->avatar) }}" placeholder="Avatar URL" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-blue-500 transition-colors mb-2">
                                <input type="file" name="avatar_file" id="avatar-file" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-500/10 file:text-blue-400 hover:file:bg-blue-500/20 file:transition-colors cursor-pointer">
                                <p class="text-xs text-slate-500 mt-2">JPG, PNG or GIF. Max size 2MB.</p>
                            </div>
                        </div>
                        @error('avatar') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        @error('avatar_file') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="bio" class="block mb-2 text-sm font-medium text-slate-300">Bio</label>
                        <textarea name="bio" id="bio" rows="4" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors" placeholder="Tell people what you build with prompts.">{{ old('bio', $user->bio ?? '') }}</textarea>
                        @error('bio') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20">
                            <i data-lucide="save" class="w-5 h-5"></i>
                            Save Changes
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-sm text-emerald-400 flex items-center gap-1">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Saved.
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                    <i data-lucide="lock" class="w-6 h-6 text-violet-400"></i>
                    Password
                </h2>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="current_password" class="block mb-2 text-sm font-medium text-slate-300">Current Password</label>
                            <input type="password" name="current_password" id="current_password" autocomplete="current-password" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500 transition-colors">
                            @error('current_password', 'updatePassword') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-slate-300">New Password</label>
                            <input type="password" name="password" id="password" autocomplete="new-password" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500 transition-colors">
                            @error('password', 'updatePassword') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-slate-300">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-violet-500 transition-colors">
                            @error('password_confirmation', 'updatePassword') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <button type="submit" class="bg-violet-500 hover:bg-violet-600 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center justify-center gap-2 shadow-lg shadow-violet-500/20">
                            <i data-lucide="key" class="w-5 h-5"></i>
                            Update Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <p class="text-sm text-emerald-400 flex items-center gap-1">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Saved.
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i data-lucide="activity" class="w-5 h-5 text-cyan-400"></i>
                    Account
                </h2>

                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm text-slate-400">Prompts</span>
                        <span class="text-white font-semibold">{{ number_format($user->prompts()->count()) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm text-slate-400">Collections</span>
                        <span class="text-white font-semibold">{{ number_format($user->collections()->count()) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm text-slate-400">Member Since</span>
                        <span class="text-white font-semibold">{{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-red-500/5 backdrop-blur-md border border-red-500/20 rounded-3xl p-6">
                <h2 class="text-lg font-bold text-red-400 mb-3 flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    Danger Zone
                </h2>
                <p class="text-slate-400 mb-5 text-sm">Deleting your account permanently removes your resources and data.</p>

                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('delete')

                    <div>
                        <label for="delete_password" class="block mb-2 text-sm font-medium text-slate-300">Password</label>
                        <input type="password" name="password" id="delete_password" placeholder="Confirm password" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors">
                        @error('password', 'userDeletion') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')" class="bg-red-500/20 hover:bg-red-500 border border-red-500/50 hover:border-red-500 text-red-400 hover:text-white px-5 py-3 rounded-xl font-semibold transition-all flex items-center justify-center gap-2 w-full">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                        Delete Account
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>
@endsection
