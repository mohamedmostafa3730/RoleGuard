<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Permission</title>
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
                <h1 class="text-3xl font-extrabold tracking-tight">Create Permission</h1>
                <p class="text-slate-500 mt-1">Define a new granular access key for the system.</p>
            </div>
            <a href="{{ route('admin.permissions.index') }}"
                class="text-sm font-medium text-slate-500 hover:text-blue-600 transition">← Back</a>
        </div>

        <!-- Form Card -->
        <form action="{{ route('admin.permissions.store') }}" method="POST"
            class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            @csrf

            <div class="p-8 space-y-6">
                <div class="bg-blue-50 border border-blue-100 p-4 rounded-2xl">
                    <p class="text-blue-700 text-xs font-medium">
                        <strong>Tip:</strong> Use a naming convention like <span
                            class="font-bold">category-action</span> (e.g., <span class="font-mono">users-edit</span> or
                        <span class="font-mono">posts-delete</span>) to keep your ACL organized.
                    </p>
                </div>

                <!-- Permission Name -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Permission Unique
                        Key</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-blue-500 font-bold text-slate-700 transition-all bg-slate-50/50"
                        placeholder="e.g., manage-billing" required>
                    @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Guard Name (Usually 'web' by default in Spatie) -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Guard
                        Name</label>
                    <input type="text" name="guard_name" value="web"
                        class="w-full px-4 py-3 rounded-xl border border-slate-100 bg-slate-100 text-slate-400 font-bold text-xs cursor-not-allowed"
                        readonly>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-slate-50 p-6 border-t border-slate-100 flex items-center justify-end">
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white rounded-xl font-black uppercase tracking-widest hover:bg-blue-700 transition active:scale-95 shadow-lg shadow-blue-200">
                    Save Permission
                </button>
            </div>
        </form>
    </div>

</body>

</html>