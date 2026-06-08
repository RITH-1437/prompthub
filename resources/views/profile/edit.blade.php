@extends('layouts.app')

@section('content')
@php $user = $user ?? auth()->user(); @endphp
<div class="max-w-4xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-bold text-white mb-2">Profile Settings</h1>
            <p class="text-slate-400">Manage your account settings and preferences.</p>
        </div>
        <a href="{{ route('users.show', $user) }}" class="bg-slate-800 hover:bg-slate-700 text-white font-semibold px-5 py-2.5 rounded-xl border border-slate-600 transition-colors flex items-center gap-2 shadow-lg shadow-black/20 w-fit">
            <i data-lucide="eye" class="w-4 h-4 text-slate-400"></i> View Public Profile
        </a>
    </div>

    <!-- Update Profile Information -->
    <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <i data-lucide="user" class="w-6 h-6 text-blue-400"></i> Profile Information
        </h2>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-slate-300">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors">
                @error('name') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-slate-300">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors">
                @error('email') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="avatar" class="block mb-2 text-sm font-medium text-slate-300">Profile Avatar</label>
                
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-full bg-slate-800 border border-slate-700 overflow-hidden flex-shrink-0 flex items-center justify-center cursor-pointer hover:scale-105 transition-transform" onclick="showAvatarModal(this.querySelector('img')?.src || '')" title="View Full Avatar">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <i data-lucide="user" class="w-8 h-8 text-slate-500"></i>
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <input type="text" name="avatar" id="avatar-url" value="{{ old('avatar', $user->avatar) }}" placeholder="Or enter avatar URL" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-blue-500 transition-colors mb-2">
                        <input type="file" name="avatar_file" id="avatar-file" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-500/10 file:text-blue-400 hover:file:bg-blue-500/20 file:transition-colors cursor-pointer focus:outline-none focus:border-blue-500 transition-colors">
                        <p class="text-xs text-slate-500 mt-2">JPG, PNG or GIF. Max size 2MB. Or enter a URL above.</p>
                    </div>
                </div>
                
                @error('avatar') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="bio" class="block mb-2 text-sm font-medium text-slate-300">Bio</label>
                <textarea name="bio" id="bio" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors" placeholder="Tell us a little about yourself...">{{ old('bio', $user->bio ?? '') }}</textarea>
                @error('bio') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center gap-2 shadow-lg shadow-blue-500/20">
                    <i data-lucide="save" class="w-5 h-5"></i> Save Changes
                </button>

                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-emerald-400 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> Saved.
                    </p>
                @endif
            </div>
        </form>
    </div>

    <!-- Update Password -->
    <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <i data-lucide="lock" class="w-6 h-6 text-violet-400"></i> Update Password
        </h2>

        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

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

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-violet-500 hover:bg-violet-600 px-6 py-3 rounded-xl text-white font-semibold transition-colors flex items-center gap-2 shadow-lg shadow-violet-500/20">
                    <i data-lucide="key" class="w-5 h-5"></i> Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <p class="text-sm text-emerald-400 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> Saved.
                    </p>
                @endif
            </div>
        </form>
    </div>

    <!-- Delete Account -->
    <div class="bg-red-500/5 backdrop-blur-md border border-red-500/20 rounded-3xl p-8">
        <h2 class="text-2xl font-bold text-red-400 mb-2 flex items-center gap-2">
            <i data-lucide="alert-triangle" class="w-6 h-6"></i> Delete Account
        </h2>
        <p class="text-slate-400 mb-6 text-sm">Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data or information that you wish to retain.</p>

        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
            @csrf
            @method('delete')

            <div>
                <label for="delete_password" class="block mb-2 text-sm font-medium text-slate-300">Password</label>
                <input type="password" name="password" id="delete_password" placeholder="Enter your password to confirm" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors">
                @error('password', 'userDeletion') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <button type="submit" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')" class="bg-red-500/20 hover:bg-red-500 border border-red-500/50 hover:border-red-500 text-red-400 hover:text-white px-6 py-3 rounded-xl font-semibold transition-all flex items-center justify-center gap-2 w-full sm:w-auto">
                <i data-lucide="trash-2" class="w-5 h-5"></i> Delete Account
            </button>
        </form>
    </div>

</div>

<!-- Avatar Modal -->
<div id="avatarModal" onclick="hideAvatarModal()" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/80 backdrop-blur-sm cursor-pointer opacity-0 transition-opacity duration-300">
    <img id="avatarModalImg" src="" alt="Avatar" class="max-w-[90vw] max-h-[90vh] rounded-3xl object-contain shadow-2xl scale-95 transition-transform duration-300">
</div>

<script>
    function showAvatarModal(src) {
        if (!src) return;
        const modal = document.getElementById('avatarModal');
        const img = document.getElementById('avatarModalImg');
        img.src = src;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            img.classList.remove('scale-95');
            img.classList.add('scale-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function hideAvatarModal() {
        const modal = document.getElementById('avatarModal');
        const img = document.getElementById('avatarModalImg');
        
        modal.classList.add('opacity-0');
        img.classList.remove('scale-100');
        img.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') hideAvatarModal();
    });
</script>
@endsection
