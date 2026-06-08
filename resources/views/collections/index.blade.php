@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                <i data-lucide="layers" class="w-8 h-8 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    My Collections
                </h1>
                <p class="text-slate-400 text-sm">Organize and group your favorite prompts.</p>
            </div>
        </div>
        
        <form action="{{ route('collections.store') }}" method="POST" class="relative z-10 flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            @csrf
            <input type="text" name="name" value="{{ old('name') }}" placeholder="New collection name" required class="min-w-0 sm:w-64 bg-slate-950/80 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors">
            <button type="submit" class="bg-white text-slate-900 font-semibold px-6 py-3 rounded-xl hover:bg-slate-200 transition-colors flex items-center justify-center gap-2 shadow-lg shadow-white/10 hover:shadow-white/20">
                <i data-lucide="plus" class="w-5 h-5"></i> Create Collection
            </button>
        </form>
        
        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-teal-500/10 blur-3xl"></div>
    </div>

    <!-- Collections Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($collections ?? [] as $collection)
            <div class="relative group bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-6 hover:bg-slate-800/60 hover:border-emerald-500/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 flex flex-col h-full">
                
                <!-- Card Header Actions -->
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center border border-emerald-500/20 text-emerald-400 group-hover:scale-110 transition-transform">
                        <i data-lucide="folder" class="w-6 h-6"></i>
                    </div>
                    <div class="flex gap-2 relative z-20">
                        <form action="{{ route('collections.destroy', $collection->id) }}" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this collection? This action cannot be undone.')" class="p-2 text-slate-400 hover:text-rose-400 bg-slate-800/50 hover:bg-slate-700 rounded-lg transition-colors border border-transparent hover:border-rose-500/30" title="Delete Collection">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Link Overlay -->
                <a href="{{ route('collections.show', $collection) }}" class="flex-1 focus:outline-none relative z-10 block">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <h2 class="text-xl font-bold text-white mb-2 group-hover:text-emerald-400 transition-colors">
                        {{ $collection->name }}
                    </h2>
                    <p class="text-sm text-slate-400 mb-6 line-clamp-2">
                        {{ $collection->description ?? 'No description provided for this collection.' }}
                    </p>
                </a>

                <div class="mt-auto pt-4 border-t border-slate-700/50 flex items-center justify-between text-sm text-slate-400">
                    <div class="flex items-center gap-2 bg-slate-800/50 px-2.5 py-1 rounded-lg border border-slate-700/50">
                        <i data-lucide="file-text" class="w-4 h-4 text-emerald-400"></i>
                        <span class="font-medium">{{ $collection->prompts_count }} Prompts</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-12 text-center flex flex-col items-center justify-center shadow-lg">
                <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mb-6 border border-slate-700/50">
                    <i data-lucide="layers" class="w-10 h-10 text-slate-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No Collections Yet</h3>
                <p class="text-slate-400 mb-8 max-w-md">You haven't created any collections. Group your prompts by topic, project, or use-case.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
