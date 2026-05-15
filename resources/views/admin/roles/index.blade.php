<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Roles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 p-12">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Manage Roles</h1>
                <p class="text-slate-500 mt-1">Define system access levels and configure specific permission sets.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                    ← Back
                </a>
            </div>
        </div>

        <div
            class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-tight">Access Control List (ACL)</span>
            </div>

            {{-- Matching 'roles-creator' --}}
            @canany(['roles-creator', 'roles-manage'])
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="{{ route('admin.roles.create') }}"
                        class="flex-1 md:flex-none text-center px-6 py-2.5 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all active:scale-95 shadow-md">
                        + Role
                    </a>
                </div>
            @endcanany
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400">Role Name</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400">Permissions</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($roles as $role)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-bold text-slate-700 uppercase text-xs">{{ $role->name }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($role->permissions as $perm)
                                        <span
                                            class="px-2 py-0.5 bg-slate-100 text-[9px] font-bold text-slate-500 rounded uppercase tracking-tighter">
                                            {{ $perm->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    {{-- Matching 'roles-editor' --}}
                                    @canany(['roles-editor', 'roles-manage'])
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                            class="px-3 py-1.5 bg-white border border-slate-200 text-[11px] font-bold text-slate-600 rounded-lg hover:bg-slate-50 transition-all shadow-sm uppercase tracking-tighter">
                                            Edit
                                        </a>
                                    @endcanany

                                    {{-- Matching 'roles-deleter' --}}
                                    @canany(['roles-deleter', 'roles-manage'])
                                        @if($role->id !== 1 && $role->name !== 'admin')
                                            <form action="{{ route('admin.roles.destroy', $role->id)}}" method="POST"
                                                onsubmit="return confirm('Delete this role?');">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="px-3 py-1.5 text-[11px] font-bold text-rose-500 hover:bg-rose-50 rounded-lg transition-all uppercase tracking-tighter">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    @endcanany
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>