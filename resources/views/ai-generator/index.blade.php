@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center shadow-lg shadow-violet-500/30">
                <i data-lucide="sparkles" class="w-8 h-8 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    AI Prompt Generator
                </h1>
                <p class="text-slate-400 text-sm">Describe what you need, and let AI craft the perfect prompt.</p>
            </div>
        </div>
        
        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-violet-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-fuchsia-500/10 blur-3xl"></div>
    </div>

    <!-- Generator Form -->
    <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8 shadow-2xl">
        <form action="/ai-generator" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300 flex items-center gap-2">
                    <i data-lucide="lightbulb" class="w-4 h-4 text-violet-400"></i> Prompt Idea
                </label>
                <input type="text" name="description" placeholder="e.g. Create a modern Laravel admin dashboard..."
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-4 text-white placeholder:text-slate-500 focus:outline-none focus:border-violet-500 transition-colors shadow-inner"
                    value="{{ old('description') }}"
                    required>
            </div>

            <div class="flex justify-end">
                <button class="bg-violet-600 hover:bg-violet-500 text-white px-8 py-3 rounded-xl font-semibold transition-all flex items-center gap-2 shadow-lg shadow-violet-500/20 border border-violet-500/50 hover:scale-105">
                    <i data-lucide="wand-2" class="w-5 h-5"></i> Generate Prompt
                </button>
            </div>
        </form>
    </div>

    @if(session('generated'))
        <!-- Generated Result -->
        <div class="bg-violet-500/5 backdrop-blur-md border border-violet-500/20 rounded-3xl p-8 shadow-2xl">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-400"></i> Generated Prompt
            </h2>

            <div class="relative bg-slate-900/80 border border-slate-700 rounded-2xl p-6 group">
                <button
                    id="generated-copy-button"
                    type="button"
                    onclick="copyGeneratedPrompt()"
                    class="absolute top-4 right-4 bg-slate-800 hover:bg-slate-700 border border-slate-600 p-2.5 rounded-xl transition-all shadow-lg hover:scale-110 z-10">
                    <i id="generated-icon-copy" data-lucide="copy" class="w-5 h-5 text-slate-300"></i>
                    <i id="generated-icon-check" data-lucide="check" class="w-5 h-5 hidden text-green-400"></i>
                </button>

                <div id="generatedPromptContent" class="pr-20 text-slate-200 leading-relaxed m-0 text-lg cursor-pointer hover:text-white transition-colors"
                    onclick="document.querySelector('input[name=\'description\']').value += (document.querySelector('input[name=\'description\']').value ? ' ' : '') + this.innerText"
                    title="Click to append to your prompt idea">
                    {!! nl2br(e(trim(session('generated')))) !!}
                </div>
            </div>
        </div>
    @endif

</div>

@endsection