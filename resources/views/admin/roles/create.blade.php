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
<form action="{{ route('admin.roles.store') }}" method="POST"
    class="max-w-2xl mx-auto bg-white p-8 rounded-3xl border border-slate-200 shadow-xl">
    @csrf
    <h2 class="text-xl font-black mb-6">Define New Role</h2>

    <div class="mb-6">
        <label class="text-[10px] font-bold uppercase text-slate-400 block mb-2">Role Title</label>
        <input type="text" name="name"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:border-blue-500 font-medium"
            placeholder="e.g., Editor">
    </div>

    <div class="mb-8">
        <label class="text-[10px] font-bold uppercase text-slate-400 block mb-4">Grant Permissions</label>
        <div class="grid grid-cols-2 gap-3">
            @foreach($permissions as $permission)
            <label
                class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer">
                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                    class="rounded text-blue-600">
                <span class="text-xs font-bold text-slate-600 uppercase">{{ $permission->name }}</span>
            </label>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <a href="{{ route('admin.roles.index') }}"
            class="text-center w-full py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-slate-800 transition shadow-lg">←
            Back</a>
        <button type="submit"
            class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-slate-800 transition shadow-lg">Save
            Role</button>
    </div>
</form>