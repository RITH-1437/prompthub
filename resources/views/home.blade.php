<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PromptHub') }} - Discover & Share AI Prompts</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-200 font-sans antialiased selection:bg-blue-500/30 selection:text-white">

    <!-- Navigation Bar -->
    <nav class="fixed w-full z-50 bg-slate-950/80 backdrop-blur-xl border-b border-slate-800/50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo.png') }}" alt="PromptHub Logo" class="w-10 h-10 rounded-xl shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform">
                <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-violet-500">PromptHub</span>
            </a>

            <!-- Right Nav Items -->
            <div class="flex items-center gap-4">
                <a href="/explore" class="text-sm font-medium text-slate-300 hover:text-white transition-colors hidden sm:block">Explore</a>
                <a href="/leaderboard" class="text-sm font-medium text-slate-300 hover:text-white transition-colors hidden sm:block">Leaderboard</a>
                
                <div class="w-px h-6 bg-slate-800 hidden sm:block mx-2"></div>
                
                @auth
                    <!-- Authenticated User Menu -->
                    <a href="/dashboard" class="text-sm font-medium text-slate-300 hover:text-white transition-colors hidden sm:block">Dashboard</a>
                    <a href="/profile" class="flex items-center gap-2.5 text-sm font-medium text-white bg-slate-800/50 hover:bg-slate-700 px-4 py-2 rounded-xl transition-colors border border-slate-700">
                        <div class="w-7 h-7 rounded-full bg-slate-800 overflow-hidden flex items-center justify-center border border-slate-600">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                            @endif
                        </div>
                        <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                    </a>
                    
                    <!-- Logout Form -->
                    <form action="/logout" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-rose-400 p-2 rounded-lg hover:bg-rose-500/10 transition-colors" title="Log out">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </button>
                    </form>
                @else
                    <!-- Guest Menu -->
                    <a href="/login" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Log in</a>
                    <a href="/register" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-500 px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-blue-500/20 hover:scale-105 border border-blue-500/50">Sign up</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden">
        
        <!-- Decorative Background Glows -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[800px] h-[400px] rounded-full bg-blue-600/10 blur-[100px] -z-10 pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/4 w-[400px] h-[400px] rounded-full bg-violet-600/10 blur-[100px] -z-10 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700/50 text-blue-400 text-sm font-medium mb-8">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                PromptHub v2.0 is live
            </div>
            
            <h1 class="text-5xl sm:text-7xl font-extrabold text-white tracking-tight mb-8 leading-tight">
                Supercharge your AI with <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-violet-500">the perfect prompt.</span>
            </h1>
            
            <p class="text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Join the largest community of AI creators. Discover, share, and collaborate on prompts for ChatGPT, Midjourney, Claude, and more.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="/prompts/create" class="w-full sm:w-auto px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-2xl transition-all shadow-lg shadow-blue-500/25 hover:scale-105 border border-blue-500/50 flex items-center justify-center gap-2">
                        <i data-lucide="plus" class="w-5 h-5"></i> Create a Prompt
                    </a>
                @else
                    <a href="/register" class="w-full sm:w-auto px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-2xl transition-all shadow-lg shadow-blue-500/25 hover:scale-105 border border-blue-500/50 flex items-center justify-center gap-2">
                        Get Started for Free <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                @endauth
                <a href="/explore" class="w-full sm:w-auto px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-2xl transition-all border border-slate-700 shadow-lg flex items-center justify-center gap-2">
                    <i data-lucide="compass" class="w-5 h-5 text-slate-400"></i> Explore Library
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-slate-900/20 border-t border-slate-800/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Everything you need to master AI</h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Stop guessing what to ask your AI. Use proven templates, organize your workflow, and build better results faster.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Feature 1 -->
                <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800 rounded-3xl p-8 hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center border border-blue-500/20 mb-6">
                        <i data-lucide="layers" class="w-7 h-7 text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Organize Collections</h3>
                    <p class="text-slate-400 leading-relaxed">Save your favorite prompts into custom collections. Keep your workflow organized for coding, marketing, or design.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800 rounded-3xl p-8 hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-violet-500/10 flex items-center justify-center border border-violet-500/20 mb-6">
                        <i data-lucide="bot" class="w-7 h-7 text-violet-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">AI Prompt Generator</h3>
                    <p class="text-slate-400 leading-relaxed">Not sure how to phrase it? Give our AI Generator a simple idea, and it will craft the perfect advanced prompt for you.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800 rounded-3xl p-8 hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center border border-emerald-500/20 mb-6">
                        <i data-lucide="users" class="w-7 h-7 text-emerald-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Community Driven</h3>
                    <p class="text-slate-400 leading-relaxed">Rate, copy, and comment on thousands of community prompts. Follow top creators and climb the leaderboard.</p>
                </div>

            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-blue-600/5 -z-10"></div>
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to generate better responses?</h2>
            <p class="text-xl text-slate-400 mb-10">Join thousands of prompt engineers and start building your library today.</p>
            @guest
                <a href="/register" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-slate-900 font-bold rounded-2xl hover:bg-slate-200 transition-colors shadow-xl shadow-white/10 hover:scale-105">
                    Create your free account
                </a>
            @else
                <a href="/explore" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-slate-900 font-bold rounded-2xl hover:bg-slate-200 transition-colors shadow-xl shadow-white/10 hover:scale-105">
                    Start Exploring
                </a>
            @endguest
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-slate-800/50 bg-slate-950 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
<div class="flex items-center gap-2 text-slate-400">
                <img src="{{ asset('images/logo.png') }}" alt="PromptHub Logo" class="w-5 h-5">
                <span class="font-semibold text-white">PromptHub</span> &copy; {{ date('Y') }}. All rights reserved.
            </div>
            <div class="flex items-center gap-6 text-sm text-slate-500">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                <a href="https://github.com" target="_blank" class="hover:text-white transition-colors">
                    <i data-lucide="github" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- Initialize Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>

</body>
</html>