@extends('layouts.admin')

@section('admin_content')
<div class="min-h-screen bg-gray-50 text-gray-900 p-6 sm:p-10">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <h1 class="text-4xl font-black tracking-tighter text-sky-600 uppercase">Peserta Raffle</h1>
                <p class="text-gray-500 italic text-sm">Data pemenang Jakarta Creative Hub Event</p>
            </div>

            <form action="{{ route('admin.index') }}" method="GET" class="flex flex-wrap gap-4 items-end bg-white p-4 rounded-2xl shadow-sm border border-gray-200">
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] uppercase tracking-widest text-sky-600 font-bold">Filter Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" 
                           class="bg-gray-50 border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                </div>
                <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-2 rounded-lg font-bold transition-all shadow-md">
                    FILTER
                </button>
                <a href="{{ route('admin.index') }}" class="text-gray-400 hover:text-gray-600 text-xs pb-3 transition-colors">Reset</a>

                <div class="flex gap-2">
                    <a href="{{ route('admin.export.excel', ['date' => request('date')]) }}" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 transition-all shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        EXCEL
                    </a>
                    
                    <a href="{{ route('admin.export.pdf', ['date' => request('date')]) }}" 
                    class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 transition-all shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        PDF
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-[30px] overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="px-8 py-6 text-sky-700 font-bold uppercase tracking-widest text-xs">Waktu</th>
                        <th class="px-8 py-6 text-sky-700 font-bold uppercase tracking-widest text-xs">Nama Peserta</th>
                        <th class="px-8 py-6 text-sky-700 font-bold uppercase tracking-widest text-xs">Hadiah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($participants as $p)
                    <tr class="hover:bg-sky-50 transition-colors group">
                        <td class="px-8 py-5 text-gray-600 text-sm font-medium">
                            {{ $p->created_at->format('d M Y - H:i') }}
                        </td>
                        <td class="px-8 py-5 font-bold text-gray-900 text-lg uppercase tracking-tight group-hover:text-sky-600 transition-colors">
                            {{ $p->name }}
                        </td>
                        <td class="px-8 py-5">
                            @php $isZonk = str_contains(strtolower($p->prize_won), 'zonk'); @endphp
                            <span class="{{ $isZonk ? 'text-gray-400 bg-gray-100 border-gray-200' : 'text-sky-700 bg-sky-50 border-sky-100 shadow-sm' }} px-4 py-1.5 rounded-full text-xs font-black uppercase italic border">
                                {{ $p->prize_won }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <span class="text-gray-300 text-5xl font-black">EMPTY</span>
                                <p class="text-gray-400 italic">Belum ada data peserta untuk hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 px-4">
            {{ $participants->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<style>
    /* Styling Pagination agar sesuai tema terang */
    .pagination { display: flex; gap: 5px; }
    .page-item .page-link { 
        background: white !important; 
        border: 1px solid #e5e7eb !important; 
        color: #0284c7 !important; 
        border-radius: 8px; 
        padding: 8px 12px;
    }
    .page-item.active .page-link { 
        background: #0284c7 !important; 
        border-color: #0284c7 !important; 
        color: white !important; 
    }
    .page-item .page-link:hover {
        background: #f0f9ff !important;
    }
</style>
@endsection