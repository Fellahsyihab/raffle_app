<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | JCH Raffle</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;800&family=Syne:wght@800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; color: #0F172A; }
        .heading-font { font-family: 'Syne', sans-serif; }
        /* Transisi halus untuk hover */
        .sidebar-link { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="antialiased">

    <div class="min-h-screen flex">
        <aside class="w-72 bg-white border-r border-slate-200 hidden lg:flex flex-col sticky top-0 h-screen">
            <div class="p-8 border-b border-slate-100">
                <h1 class="heading-font text-2xl tracking-tighter uppercase font-black">
                    JCH <span class="text-sky-500 italic">Admin</span>
                </h1>
            </div>
            
            <nav class="flex-1 p-6 space-y-3">

                <a href="{{ route('raffle.index') }}" target="_blank"
                class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold text-sky-600 bg-sky-50 hover:bg-sky-100 transition-all mb-8">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    View Live Game
                </a>

                <a href="{{ route('dashboard') }}" 
                class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold sidebar-link {{ Request::is('dashboard') ? 'bg-[#0F172A] text-white shadow-xl shadow-slate-200' : 'text-slate-400 hover:bg-sky-50 hover:text-sky-500' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.index') }}" 
                class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold sidebar-link {{ Request::is('admin/prizes') ? 'bg-[#0F172A] text-white shadow-xl shadow-slate-200' : 'text-slate-400 hover:bg-sky-50 hover:text-sky-500' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Input Prize
                </a>
            </nav>

            <div class="p-8 border-t border-slate-100">
                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl">
                    <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white font-black text-xs shadow-lg">
                        IT
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-slate-900">IT Team</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">JCH HUB</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 px-8 py-5 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Core System</span>
                    <span class="text-slate-200">/</span>
                    <span class="text-[10px] font-black text-slate-900 uppercase tracking-[0.3em]">
                        {{ Request::is('admin/prizes*') ? 'Inventory' : 'Analytics' }}
                    </span>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">System Live</span>
                        <span class="text-[9px] text-slate-400 font-bold uppercase">{{ date('d M Y') }}</span>
                    </div>
                    <div class="h-8 w-[1px] bg-slate-100"></div>
                    <button class="text-slate-400 hover:text-rose-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </div>
            </header>

            <div class="p-8 lg:p-12">
                @yield('admin_content')
            </div>
        </main>
    </div>

</body>
</html>