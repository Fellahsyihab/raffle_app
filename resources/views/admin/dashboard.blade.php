@extends('layouts.admin')

@section('admin_content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
    .stat-title { color: #6b7280; font-size: 0.875rem; font-weight: 500; }
    .stat-value { font-size: 2.25rem; font-weight: 700; margin: 0.5rem 0; }
    .stat-desc { font-size: 0.75rem; display: flex; align-items: center; gap: 0.25rem; }
</style>

<div class="py-10">
    <div class="max-w-7xl mx-auto px-6">
        
        <h2 class="text-xl font-bold text-slate-800 mb-4 px-2">Statistic</h2>

        <div class="grid grid-cols-3 gap-4 mb-8">
            
            <div class="bg-blue-600 rounded-2xl p-5 shadow-sm text-white">
                <p class="text-blue-100 text-[11px] font-semibold uppercase tracking-wider">Total Distribusi</p>
                <h3 class="text-3xl font-bold my-1">
                    {{ \App\Models\Participant::where('prize_won', '!=', 'Zonk')->count() }}
                </h3>
                <div class="flex items-center gap-1 text-[10px] text-blue-100/80">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span>Live data inventory</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <p class="text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Total Peserta</p>
                <h3 class="text-3xl font-bold my-1 text-blue-600">
                    {{ \App\Models\Participant::count() }}
                </h3>
                <div class="flex items-center gap-1 text-[10px] text-slate-400">
                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span class="text-blue-600 font-bold">Aktif</span> dalam sistem
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <p class="text-slate-400 text-[11px] font-semibold uppercase tracking-wider">Varian Hadiah</p>
                <h3 class="text-3xl font-bold my-1 text-blue-600">
                    {{ $prizes->count() }}
                </h3>
                <div class="flex items-center gap-1 text-[10px] text-slate-400">
                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span class="text-blue-600 font-bold">Tipe</span> terdaftar
                </div>
            </div>

        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-1.5 h-5 bg-blue-600 rounded-full"></div>
                    <h3 class="font-bold text-slate-800">Tambah Asset Baru</h3>
                </div>
                <form action="{{ route('admin.add') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
                    @csrf
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Nama Item</label>
                        <input type="text" name="name" placeholder="E.g. Tumbler JCH" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    </div>
                    <div class="w-full md:w-32">
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Stok</label>
                        <input type="number" name="stock" value="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-center focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-md shadow-blue-100 transition-all active:scale-95">
                        Simpan Asset
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Asset Name</th>
                            <th class="px-6 py-4 text-center">In Stock</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($prizes as $prize)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-700">{{ $prize->name }}</td>
                            <td class="px-6 py-4 text-center font-mono font-bold">{{ $prize->stock }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $prize->stock > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                    {{ $prize->stock > 0 ? 'READY' : 'OUT' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.update', $prize->id) }}" method="POST" class="flex justify-end gap-2">
                                    @csrf
                                    <input type="number" name="stock" value="{{ $prize->stock }}" class="w-16 bg-slate-100 border-none rounded-lg text-center text-xs font-bold py-1">
                                    <button type="submit" class="bg-slate-800 text-white p-1.5 rounded-lg hover:bg-blue-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection