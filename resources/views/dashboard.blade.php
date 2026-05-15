<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex flex-col md:flex-row">
        <aside class="w-full md:w-72 bg-slate-900 md:min-h-screen text-slate-300 transition-all">
            <div class="p-6">
                <div class="text-white text-xl font-bold flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-sm shadow-lg shadow-blue-900/50">
                        S</div>
                    SUPER CONTROL
                </div>
            </div>

            <nav class="mt-4 px-4 space-y-6">
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl bg-blue-600/10 text-blue-400 border border-blue-600/20">
                        <span>🏠</span> Overview
                    </a>
                </div>

                @role('admin|user-manager|role-manager|permission-manager')
                <div>
                    <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">System Control
                    </p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800 hover:text-white transition-all">
                            <span>👥</span> Users Management
                        </a>
                        <a href="{{ route('admin.roles.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800 hover:text-white transition-all">
                            <span>🔑</span> Roles Management
                        </a>
                        <a href="{{ route('admin.permissions.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800 hover:text-white transition-all">
                            <span>🛡️</span> Permissions Management
                        </a>
                    </div>
                </div>
                @endrole

                <div>
                    <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Account</p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-rose-400 hover:bg-rose-500/10 transition-all text-left">
                            <span>🚪</span> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <main class="flex-1">
            <header
                class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-10">
                <div>
                    <h1 class="text-lg font-bold text-slate-800 tracking-tight">Console Overview</h1>
                    <p class="text-[11px] text-slate-400 uppercase font-bold tracking-tighter italic">System Pulse &
                        Data</p>
                </div>
            </header>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Users</p>
                        <div class="text-3xl font-black text-slate-800">{{ \App\Models\User::count() }}</div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">System Roles</p>
                        <div class="text-3xl font-black text-slate-800">{{ \Spatie\Permission\Models\Role::count() }}
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Files Hosted</p>
                        <div class="text-3xl font-black text-slate-800">
                            {{ \Spatie\MediaLibrary\MediaCollections\Models\Media::count() }}</div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="text-slate-800 text-lg font-bold mb-6">User Identity Info</h3>
                    <div class="flex items-center gap-8">
                        <div class="w-24 h-24 rounded-3xl bg-blue-50 border-4 border-white shadow-xl overflow-hidden">
                            <img src="{{ $user->getFirstMediaUrl('avatars') ?: 'https://ui-avatars.com/api/?name='.$user->name }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="space-y-2">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Authenticated As</p>
                                <p class="text-xl font-black text-slate-800">{{ $user->name }}</p>
                            </div>
                            <div class="flex gap-2">
                                <span
                                    class="px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-lg">{{ $user->getRoleNames()->first() }}</span>
                                <span
                                    class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-bold rounded-lg">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>