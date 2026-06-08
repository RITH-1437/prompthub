@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">
    
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center shadow-lg shadow-violet-500/30 text-white text-4xl font-bold uppercase overflow-hidden cursor-pointer hover:scale-105 transition-transform" onclick="showAvatarModal(this.querySelector('img')?.src || '')">
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    {{ substr($user->name, 0, 1) }}
                @endif
            </div>
            <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">
                    {{ $user->name }}
                </h1>
                <p class="text-slate-400 text-sm max-w-xl">
                    {{ $user->bio ?? 'No bio available.' }}
                </p>
            </div>
        </div>

        <div class="relative z-10 flex items-center gap-3">
            @if(auth()->check() && auth()->id() !== $user->id)
                @if($user->followers->contains(auth()->id()))
                    <form action="/follow/{{ $user->id }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button class="bg-slate-800 hover:bg-slate-700 text-white font-semibold px-6 py-3 rounded-xl border border-slate-600 transition-colors flex items-center gap-2 shadow-lg shadow-black/20">
                            <i data-lucide="user-minus" class="w-5 h-5 text-slate-400"></i> Unfollow
                        </button>
                    </form>
                @else
                    <form action="/follow/{{ $user->id }}" method="POST" class="m-0">
                        @csrf
                        <button class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition-colors flex items-center gap-2 shadow-lg shadow-blue-500/20 border border-blue-500/50">
                            <i data-lucide="user-plus" class="w-5 h-5"></i> Follow
                        </button>
                    </form>
                @endif
            @elseif(!auth()->check())
                <form action="/follow/{{ $user->id }}" method="POST" class="m-0">
                    @csrf
                    <button class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-xl transition-colors flex items-center gap-2 shadow-lg shadow-blue-500/20 border border-blue-500/50">
                        <i data-lucide="user-plus" class="w-5 h-5"></i> Follow
                    </button>
                </form>
            @else
                <a href="{{ route('profile.edit') }}" class="bg-slate-800 hover:bg-slate-700 text-white font-semibold px-6 py-3 rounded-xl border border-slate-600 transition-colors flex items-center gap-2 shadow-lg shadow-black/20">
                    <i data-lucide="settings" class="w-5 h-5 text-slate-400"></i> Edit Profile
                </a>
            @endif
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 md:gap-6">
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:bg-slate-800/60 transition-colors group">
            <i data-lucide="file-text" class="w-6 h-6 text-blue-400 mb-2 group-hover:scale-110 transition-transform"></i>
            <div class="text-3xl font-bold text-white mb-1">{{ number_format($prompts->count()) }}</div>
            <div class="text-slate-400 text-xs font-medium uppercase tracking-wider">Prompts</div>
        </div>
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:bg-slate-800/60 transition-colors group">
            <i data-lucide="eye" class="w-6 h-6 text-cyan-400 mb-2 group-hover:scale-110 transition-transform"></i>
            <div class="text-3xl font-bold text-white mb-1">{{ number_format($totalViews) }}</div>
            <div class="text-slate-400 text-xs font-medium uppercase tracking-wider">Views</div>
        </div>
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:bg-slate-800/60 transition-colors group">
            <i data-lucide="copy" class="w-6 h-6 text-emerald-400 mb-2 group-hover:scale-110 transition-transform"></i>
            <div class="text-3xl font-bold text-white mb-1">{{ number_format($totalCopies) }}</div>
            <div class="text-slate-400 text-xs font-medium uppercase tracking-wider">Copies</div>
        </div>
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:bg-slate-800/60 transition-colors group">
            <i data-lucide="users" class="w-6 h-6 text-violet-400 mb-2 group-hover:scale-110 transition-transform"></i>
            <div class="text-3xl font-bold text-white mb-1">{{ $user->followers->count() }}</div>
            <div class="text-slate-400 text-xs font-medium uppercase tracking-wider">Followers</div>
        </div>
        <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 flex flex-col items-center justify-center hover:bg-slate-800/60 transition-colors group col-span-2 lg:col-span-1">
            <i data-lucide="user-check" class="w-6 h-6 text-fuchsia-400 mb-2 group-hover:scale-110 transition-transform"></i>
            <div class="text-3xl font-bold text-white mb-1">{{ $user->following->count() }}</div>
            <div class="text-slate-400 text-xs font-medium uppercase tracking-wider">Following</div>
        </div>
    </div>

    <!-- Public Prompts -->
    <div>
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
            <i data-lucide="layers" class="w-6 h-6 text-blue-400"></i> Public Prompts
        </h2>
        <div class="space-y-4">
            @forelse($prompts as $prompt)
                <a href="/prompts/{{ $prompt->id }}" class="block relative group bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-2xl p-6 hover:bg-slate-800/60 hover:border-blue-500/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl font-bold text-white mb-2 truncate group-hover:text-blue-400 transition-colors">
                                {{ $prompt->title }}
                            </h3>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                    {{ optional($prompt->category)->name ?? 'Uncategorized' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-slate-400 bg-slate-800/50 px-4 py-2 rounded-xl border border-slate-700/50 w-fit">
                            <div class="flex items-center gap-1.5" title="Views">
                                <i data-lucide="eye" class="w-4 h-4 text-cyan-400"></i>
                                <span class="font-medium">{{ number_format($prompt->views_count ?? 0) }}</span>
                            </div>
                            <div class="w-px h-4 bg-slate-700"></div>
                            <div class="flex items-center gap-1.5" title="Copies">
                                <i data-lucide="copy" class="w-4 h-4 text-emerald-400"></i>
                                <span class="font-medium">{{ number_format($prompt->copy_count ?? 0) }}</span>
                            </div>
                            <div class="w-px h-4 bg-slate-700"></div>
                            <div class="flex items-center gap-1.5" title="Comments">
                                <i data-lucide="message-circle" class="w-4 h-4 text-blue-400"></i>
                                <span class="font-medium">{{ number_format($prompt->comments_count ?? 0) }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-12 text-center flex flex-col items-center justify-center shadow-lg">
                    <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                        <i data-lucide="inbox" class="w-10 h-10 text-slate-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">No Public Prompts</h3>
                    <p class="text-slate-400 max-w-md">This user hasn't published any public prompts yet.</p>
                </div>
            @endforelse
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
