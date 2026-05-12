<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen p-4 md:p-12">

    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Manage Users</h1>
                <p class="text-slate-500 mt-1">Review permissions and assign roles to your team members.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Success/Error Alerts -->
        @if(session('success'))
        <div
            class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl flex items-center gap-3">
            <span class="font-medium">✅ {{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-xl flex items-center gap-3">
            <span class="font-medium">⚠️ {{ session('error') }}</span>
        </div>
        @endif

        <!-- Quick Actions Bar -->
        <div
            class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-tight">Active Directory
                    Management</span>
            </div>

            @can('users-manage')
            <div class="flex gap-3 w-full md:w-auto">
                <a href="{{ route('admin.users.create') }}"
                    class="flex-1 md:flex-none text-center px-6 py-2.5 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all active:scale-95 shadow-md">
                    Add New Identity
                </a>
            </div>
            @endcan
        </div>

        <!-- Users Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">User</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Status &
                                Contact</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Assigned
                                Roles</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center">
                                        @if($user->getFirstMediaUrl('avatars'))
                                        <img src="{{ $user->getFirstMediaUrl('avatars') }}"
                                            class="w-full h-full object-cover">
                                        @else
                                        <span
                                            class="text-slate-400 text-sm font-bold">{{ substr($user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 text-sm">{{ $user->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">UID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600">{{ $user->email }}</div>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full {{ $user->hasVerifiedEmail() ? 'bg-emerald-500' : 'bg-amber-400' }}"></span>
                                    <span class="text-[9px] uppercase font-black text-slate-400">
                                        {{ $user->hasVerifiedEmail() ? 'Verified' : 'Pending' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($user->roles as $role)
                                    <span
                                        class="px-2 py-0.5 rounded-md text-[10px] font-bold border uppercase
                                        {{ $role->name === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 'bg-blue-50 text-blue-700 border-blue-100' }}">
                                        {{ $role->name }}
                                    </span>
                                    @empty
                                    <span class="text-[10px] text-slate-400 italic font-medium">Guest</span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @can('users-manage')
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="px-3 py-1.5 bg-white border border-slate-200 text-[11px] font-bold text-slate-600 rounded-lg hover:bg-slate-50 transition-all shadow-sm uppercase tracking-tighter">
                                        Edit Access
                                    </a>
                                    @endcan

                                    @can('users-manage')
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Archive this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-3 py-1.5 text-[11px] font-bold text-rose-500 hover:bg-rose-50 rounded-lg transition-all uppercase tracking-tighter">
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    System Record: {{ $users->count() }} Total Identities
                </p>
            </div>
        </div>
    </div>

</body>

</html>