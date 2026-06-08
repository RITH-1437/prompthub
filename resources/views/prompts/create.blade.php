@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <i data-lucide="plus-circle" class="w-8 h-8 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    Create New Prompt
                </h1>
                <p class="text-slate-400 text-sm">Craft a new AI prompt and share it with the community.</p>
            </div>
        </div>
        
        <a href="{{ route('prompts.index') }}" class="relative z-10 bg-slate-800 hover:bg-slate-700 text-white font-semibold px-5 py-2.5 rounded-xl border border-slate-600 transition-colors flex items-center gap-2 shadow-lg shadow-black/20">
            <i data-lucide="arrow-left" class="w-4 h-4 text-slate-400"></i> Back
        </a>

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <!-- Form Section -->
    <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8 shadow-2xl">
        <form action="{{ route('prompts.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300 flex items-center gap-2">
                    <i data-lucide="type" class="w-4 h-4 text-blue-400"></i> Title
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Laravel Expert Developer..."
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300 flex items-center gap-2">
                    <i data-lucide="folder" class="w-4 h-4 text-blue-400"></i> Category
                </label>
                <select name="category_id" required
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors appearance-none">
                    <option value="" disabled selected>Select a category...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300 flex items-center gap-2">
                    <i data-lucide="align-left" class="w-4 h-4 text-blue-400"></i> Content
                </label>
                <textarea name="content" rows="8" required placeholder="Write your prompt here..."
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors">{{ old('content') }}</textarea>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300 flex items-center gap-2">
                    <i data-lucide="hash" class="w-4 h-4 text-blue-400"></i> Tags
                </label>
                <input type="text" name="tags" value="{{ old('tags') }}" placeholder="ai, coding, laravel"
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 transition-colors">
                <p class="text-slate-500 text-xs mt-2">Separate tags with commas.</p>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-xl font-semibold transition-all flex items-center gap-2 shadow-lg shadow-blue-500/20 border border-blue-500/50 hover:scale-105">
                    <i data-lucide="save" class="w-5 h-5"></i> Publish Prompt
                </button>
            </div>
        </form>
    </div>
</div>
@endsection