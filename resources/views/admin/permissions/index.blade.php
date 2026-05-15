<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Permissions</title>
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
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">System Permissions</h1>
                <p class="text-slate-500 mt-1">The granular building blocks of your security model.</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                ← Back
            </a>
        </div>

        <!-- Action Bar (ACL Label + Create Button) -->
        <div
            class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-tight">Access Control List (ACL)</span>
            </div>

            @can('permissions-manage')
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="{{ route('admin.permissions.create') }}"
                        class="flex-1 md:flex-none text-center px-6 py-2.5 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all active:scale-95 shadow-md">
                        Create Permission
                    </a>
                </div>
            @endcan
        </div> {{-- Closed the action bar here --}}

        <!-- Table Section (Now correctly placed outside the bar) -->
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400">Permission Key</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400">Guard</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($permissions as $permission)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-mono text-xs font-bold text-blue-600">{{ $permission->name }}</td>
                            <td class="px-6 py-4 text-xs text-slate-400 font-bold uppercase">
                                {{ $permission->guard_name }}
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-4">
                                <div class="flex justify-end gap-2">
                                    @can('permissions-manage')
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                            class="px-3 py-1.5 bg-white border border-slate-200 text-[11px] font-bold text-slate-600 rounded-lg hover:bg-slate-50 transition-all shadow-sm uppercase tracking-tighter">
                                            Edit Access
                                        </a>
                                    @endcan

                                    @can('permissions-manage')
                                        @if($permission->id !== 1 && $permission->name !== 'Admin')
                                            <form action="{{ route('admin.permissions.destroy', $permission->id)}}" method="POST"
                                                onsubmit="return confirm('Delete this permission?');">
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
    </div> {{-- Closed max-w-4xl --}}
</body>