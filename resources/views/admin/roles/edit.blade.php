<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Role - {{ $role->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen p-4 md:p-12">

    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">Edit Role</h1>
                <p class="text-slate-500 mt-1">Modify permissions for the <span
                        class="text-blue-600 font-bold uppercase">{{ $role->name }}</span> identity.</p>
            </div>
            <a href="{{ route('admin.roles.index') }}"
                class="text-sm font-medium text-slate-500 hover:text-blue-600 transition">← Back</a>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST"
            class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            @csrf
            @method('PUT')

            <div class="p-8 space-y-6">
                <!-- Role Name -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Role
                        Title</label>
                    <input type="text" name="name" value="{{ old('name', $role->name) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-blue-500 font-medium transition-all"
                        placeholder="e.g., Moderator">
                    @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permissions Grid -->
                <div class="space-y-3">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Assign
                        Permissions</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($permissions as $permission)
                        <label
                            class="flex items-center gap-3 p-4 rounded-2xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                            <span
                                class="text-xs font-bold text-slate-600 uppercase tracking-tight">{{ $permission->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-slate-50 p-6 border-t border-slate-100 flex items-center justify-end">
                <button type="submit"
                    class="px-8 py-3 bg-slate-900 text-white rounded-xl font-black uppercase tracking-widest hover:bg-slate-800 transition active:scale-95 shadow-lg">
                    Update Role
                </button>
            </div>
        </form>
    </div>

</body>

</html>