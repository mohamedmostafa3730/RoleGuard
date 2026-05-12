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

<body class="bg-slate-50 p-12">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Manage Roles</h1>
                <p class="text-slate-500 mt-1">Define system access levels and configure specific permission sets.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                    ← Back to Users
                </a>
            </div>
        </div>

        <!-- Quick Actions Bar for Roles -->
        <div
            class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-tight">Access Control List (ACL)</span>
            </div>

            @can('create-roles')
            <div class="flex gap-3 w-full md:w-auto">
                <a href="{{ route('admin.roles.create') }}"
                    class="flex-1 md:flex-none text-center px-6 py-2.5 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all active:scale-95 shadow-md">
                    Define New Role
                </a>
            </div>
            @endcan
        </div>
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-black text-slate-900">System Roles</h1>
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
                                    class="px-2 py-0.5 bg-slate-100 text-[9px] font-bold text-slate-500 rounded uppercase tracking-tighter">{{ $perm->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                                class="text-xs font-black text-blue-600 uppercase">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>