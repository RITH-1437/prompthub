@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12 font-sans">

    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 to-slate-800 p-8 border border-slate-700/50 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
<img src="{{ asset('images/logo.png') }}" alt="PromptHub Logo" class="w-16 h-16 rounded-2xl shadow-lg shadow-indigo-500/30">
                <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">
                    Manage Users
                </h1>
                <p class="text-slate-400 text-sm">Review, manage roles, or remove users from the platform.</p>
            </div>
        </div>

        <!-- Decorative glows -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-indigo-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-purple-500/10 blur-3xl"></div>
    </div>

    <!-- Users Table -->
    <div class="bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="border-b border-slate-700/50 bg-slate-800/30 text-xs uppercase tracking-wider text-slate-400">
                        <th class="py-4 px-6 font-semibold">User</th>
                        <th class="py-4 px-6 font-semibold">Role</th>
                        <th class="py-4 px-6 font-semibold">Joined</th>
                        <th class="py-4 px-6 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-800/30 transition-colors group">
                            <td class="py-4 px-6">
                                <a href="/users/{{ $user->id }}" class="flex items-center gap-3 group/user w-fit">
                                    <div class="w-10 h-10 rounded-full bg-slate-800 overflow-hidden flex items-center justify-center border border-slate-700 shrink-0">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-200 group-hover/user:text-white transition-colors">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                @if($user->is_admin)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 uppercase tracking-wider">
                                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-500/10 text-slate-400 border border-slate-500/20 uppercase tracking-wider">
                                        <i data-lucide="user" class="w-3.5 h-3.5"></i> User
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-400">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                    {{ $user->created_at ? $user->created_at->format('M d, Y') : 'Unknown' }}
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="/admin/users/{{ $user->id }}/{{ $user->is_admin ? 'revoke-admin' : 'grant-admin' }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="flex items-center justify-center gap-2 {{ $user->is_admin ? 'bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-600' : 'bg-indigo-500/10 hover:bg-indigo-500 border border-indigo-500/30 text-indigo-400 hover:text-white' }} px-3 py-2 rounded-xl font-medium text-xs transition-all w-28">
                                            @if($user->is_admin)
                                                <i data-lucide="shield-off" class="w-3.5 h-3.5"></i> Revoke
                                            @else
                                                <i data-lucide="shield" class="w-3.5 h-3.5"></i> Grant Admin
                                            @endif
                                        </button>
                                    </form>

                                    @if($user->id !== auth()->id())
                                    <form action="/admin/users/{{ $user->id }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')" class="flex items-center justify-center gap-2 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 hover:border-rose-500 text-rose-400 hover:text-white px-3 py-2 rounded-xl font-medium text-xs transition-all group/btn w-24">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5 group-hover/btn:animate-bounce"></i> Delete
                                        </button>
                                    </form>
                                    @else
                                    <div class="w-24 px-3 py-2 text-center text-xs text-slate-600 font-medium italic">
                                        (You)
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center text-slate-500">
                                <i data-lucide="users" class="w-12 h-12 mx-auto mb-4 opacity-50"></i>
                                <p>No users found on the platform.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($users) && $users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages())
        <div class="mt-8">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection