<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen py-12 px-6">

    <div class="max-w-2xl mx-auto">
        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition mb-6 gap-2">
            <span>←</span> Back to User Management
        </a>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-blue-200">
                        +
                    </div>
                    <div>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900">Create Identity</h1>
                        <p class="text-slate-500 text-sm">Register a new team member and assign their system
                            permissions.</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.users.store') }}" enctype="multipart/form-data" method="POST"
                class="p-8 space-y-6">
                @csrf

                <!-- Identity Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Full
                            Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-medium">
                        @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1 col-span-full">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Profile
                            Photo</label>
                        <div
                            class="mt-2 flex items-center gap-4 p-4 border-2 border-dashed border-slate-200 rounded-2xl hover:border-blue-400 transition-colors bg-slate-50/50">
                            <input type="file" name="avatar" accept="image/*"
                                class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                        </div>
                        @error('avatar') <p class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}
                        </p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1">Email
                            Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-medium">
                        @error('email') <p class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Section -->
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 space-y-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Security Credentials</h3>
                        <p class="text-xs text-slate-400">Ensure the password is at least 8 characters long.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="password" name="password" placeholder="Password"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white focus:ring-4 focus:ring-blue-500/10 outline-none text-sm">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white focus:ring-4 focus:ring-blue-500/10 outline-none text-sm">
                    </div>
                    @error('password') <p class="text-rose-500 text-[10px] font-bold uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Roles Section -->
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-1 mb-3 block">Assign
                        Roles</label>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($roles as $role)
                        <label
                            class="group relative flex items-center p-4 rounded-2xl border border-slate-200 cursor-pointer hover:bg-blue-50/50 transition-all has-[:checked]:bg-blue-50 has-[:checked]:border-blue-300">
                            <div class="flex-1">
                                <span
                                    class="block font-bold text-slate-700 group-hover:text-blue-700 transition-colors uppercase text-xs tracking-tight">
                                    {{ $role->name }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-medium">
                                    {{ $role->name === 'admin' ? 'Grants total control over users, roles, and system settings.' : 'Standard dashboard access.' }}
                                </span>
                            </div>
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                class="w-5 h-5 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all cursor-pointer">
                        </label>
                        @endforeach
                    </div>
                    @error('roles') <p class="text-rose-500 text-[10px] font-bold uppercase mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="pt-4 space-y-3">
                    <button type="submit"
                        class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 active:scale-[0.98]">
                        Create User
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="w-full block py-4 bg-white text-slate-400 rounded-2xl font-bold text-center text-sm hover:text-slate-600 transition-colors">
                        Discard
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>