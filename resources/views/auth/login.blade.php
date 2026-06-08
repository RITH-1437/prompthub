@extends('layouts.guest')

@section('content')
<div class="w-full min-h-[80vh] flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
    
    <!-- Login Header -->
    <div class="w-full sm:mx-auto sm:max-w-md text-center mb-8 relative z-20">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-violet-600 shadow-lg shadow-blue-500/30 mb-4">
            <i data-lucide="zap" class="w-8 h-8 text-white"></i>
        </div>
        <h2 class="text-3xl font-extrabold text-white tracking-tight">
            Welcome Back
        </h2>
        <p class="mt-2 text-sm text-slate-400">
            Sign in to your account to continue
        </p>
    </div>

    <div class="w-full sm:mx-auto sm:max-w-md relative">
        <!-- Decorative glows -->
        <div class="absolute -top-10 -left-10 w-48 h-48 rounded-full bg-blue-500/20 blur-3xl -z-10"></div>
        <div class="absolute -bottom-10 -right-10 w-48 h-48 rounded-full bg-violet-500/20 blur-3xl -z-10"></div>

        <!-- Login Card -->
        <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-700/50 rounded-3xl py-8 px-4 shadow-2xl sm:px-10 relative z-10">
            <form class="space-y-6" action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">
                        Email address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="h-5 w-5 text-slate-500"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="appearance-none block w-full pl-12 pr-4 py-3 bg-slate-900/80 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-colors sm:text-sm shadow-inner" placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-5 w-5 text-slate-500"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full pl-12 pr-4 py-3 bg-slate-900/80 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-colors sm:text-sm shadow-inner" placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 bg-slate-900 border-slate-700 rounded text-blue-500 focus:ring-blue-500 focus:ring-offset-slate-900">
                        <label for="remember" class="ml-2 block text-sm text-slate-400">
                            Remember me
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/20 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-slate-900 transition-all hover:scale-[1.02]">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-slate-400">
                    Don't have an account? 
                    <a href="/register" class="font-medium text-blue-400 hover:text-blue-300 transition-colors">
                        Sign up now
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection