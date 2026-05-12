<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Permission</title>
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
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">Modify Permission</h1>
                <p class="text-slate-500 mt-1">Updating: <span
                        class="font-mono font-bold text-blue-600">{{ $permission->name }}</span></p>
            </div>
            <a href="{{ route('admin.permissions.index') }}"
                class="text-sm font-medium text-slate-500 hover:text-blue-600 transition">← Back</a>
        </div>

        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST"
            class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            @csrf
            @method('PUT')

            <div class="p-8 space-y-6">
                <div class="bg-amber-50 border border-amber-100 p-4 rounded-2xl">
                    <p class="text-amber-700 text-xs font-medium">
                        <strong>Warning:</strong> Renaming this will affect all associated roles immediately.
                    </p>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Permission Unique
                        Key</label>
                    <input type="text" name="name" value="{{ old('name', $permission->name) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-blue-500 font-bold text-slate-700 transition-all"
                        required>
                    @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-slate-50 p-6 border-t border-slate-100 flex items-center justify-end">
                <button type="submit"
                    class="px-8 py-3 bg-slate-900 text-white rounded-xl font-black uppercase tracking-widest hover:bg-slate-800 transition active:scale-95 shadow-lg">
                    Update Permission
                </button>
            </div>
        </form>
    </div>

</body>

</html>