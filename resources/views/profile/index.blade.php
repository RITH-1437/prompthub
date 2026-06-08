@extends('layouts.app')

@section('content')
<div class="w-full mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center shadow-lg shadow-violet-500/30 text-white text-3xl font-bold uppercase overflow-hidden cursor-pointer hover:scale-105 transition-transform" onclick="showAvatarModal(this.querySelector('img')?.src || '')" title="View Full Avatar">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                @else
                    {{ substr(auth()->user()->name, 0, 1) }}
                @endif
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    {{ auth()->user()->name }}
                </h1>
                <p class="text-slate-400 text-sm flex items-center gap-2">
                    <i data-lucide="mail" class="w-4 h-4"></i> {{ auth()->user()->email }}
                </p>
                <p class="text-slate-500 text-xs mt-1">
                    Member since {{ auth()->user()->created_at->format('F Y') }}
                </p>
            </div>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <a href="{{ route('users.show', auth()->user()) }}" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 border border-blue-500/50 w-full sm:w-auto">
                <i data-lucide="eye" class="w-4 h-4"></i> Public Profile
            </a>
            <a href="{{ route('profile.edit') }}" class="bg-slate-800 hover:bg-slate-700 text-white font-semibold px-5 py-2.5 rounded-xl border border-slate-600 transition-colors flex items-center justify-center gap-2 shadow-lg shadow-black/20 w-full sm:w-auto">
                <i data-lucide="settings" class="w-4 h-4 text-slate-400"></i> Edit Profile
            </a>
        </div>
        
        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-violet-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-fuchsia-500/10 blur-3xl"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stats Cards -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 flex items-center gap-4 hover:bg-slate-800/60 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center">
                <i data-lucide="file-text" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium">My Prompts</p>
                <p class="text-2xl font-bold text-white">{{ auth()->user()->prompts()->count() ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 flex items-center gap-4 hover:bg-slate-800/60 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                <i data-lucide="folder" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium">Collections</p>
                <p class="text-2xl font-bold text-white">{{ auth()->user()->collections()->count() ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 flex items-center gap-4 hover:bg-slate-800/60 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center">
                <i data-lucide="heart" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium">Favorites</p>
                <p class="text-2xl font-bold text-white">{{ auth()->user()->favorites()->count() ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity / Quick Links -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8">
            <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                <i data-lucide="zap" class="w-5 h-5 text-yellow-400"></i> Quick Actions
            </h2>
            <div class="space-y-4">
                <a href="/prompts/create" class="flex items-center justify-between p-4 rounded-xl bg-slate-800/50 hover:bg-slate-800 border border-slate-700/50 hover:border-slate-600 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="plus" class="w-5 h-5"></i>
                        </div>
                        <span class="font-medium text-slate-200 group-hover:text-white transition-colors">Create New Prompt</span>
                    </div>
                    <i data-lucide="chevron-right" class="w-5 h-5 text-slate-500 group-hover:text-slate-300 transition-colors"></i>
                </a>
                <a href="/collections" class="flex items-center justify-between p-4 rounded-xl bg-slate-800/50 hover:bg-slate-800 border border-slate-700/50 hover:border-slate-600 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="layers" class="w-5 h-5"></i>
                        </div>
                        <span class="font-medium text-slate-200 group-hover:text-white transition-colors">Manage Collections</span>
                    </div>
                    <i data-lucide="chevron-right" class="w-5 h-5 text-slate-500 group-hover:text-slate-300 transition-colors"></i>
                </a>
            </div>
        </div>

        <!-- Recent Prompts -->
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8 flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-blue-400"></i> Recent Prompts
                </h2>
                <a href="/prompts" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">View All</a>
            </div>
            
            <div class="space-y-4 flex-1">
                @forelse(auth()->user()->prompts()->withCount('favorites')->latest()->take(3)->get() as $prompt)
                    <a href="/prompts/{{ $prompt->id }}" class="block p-4 rounded-xl bg-slate-800/30 hover:bg-slate-800/80 border border-slate-700/30 hover:border-slate-600 transition-all group">
                        <h3 class="font-semibold text-slate-200 group-hover:text-white mb-1 truncate">{{ $prompt->title }}</h3>
                        <div class="flex items-center gap-4 text-xs text-slate-500">
                            <span class="flex items-center gap-1"><i data-lucide="eye" class="w-3.5 h-3.5"></i> {{ $prompt->views_count ?? 0 }}</span>
                            <span class="flex items-center gap-1"><i data-lucide="heart" class="w-3.5 h-3.5"></i> {{ $prompt->favorites_count ?? 0 }}</span>
                            <span class="ml-auto flex items-center gap-1"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ $prompt->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center h-full py-6 text-slate-500">
                        <i data-lucide="inbox" class="w-10 h-10 mb-2 opacity-50"></i>
                        <p class="text-sm">No prompts created yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
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
