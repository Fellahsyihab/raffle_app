<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prize;
use App\Models\Participant;

class RaffleController extends Controller
{

    public function index() {
        // Ambil nama hadiah yang stoknya > 0 atau bernama Zonk
        $prizes = Prize::where('stock', '>', 0)
                      ->orWhere('name', 'like', '%Zonk%')
                      ->pluck('name'); // Mengambil array nama saja

        return view('raffle', compact('prizes'));
    }

    public function draw(Request $request) {
        // 1. Ambil hadiah yang stoknya > 0 ATAU yang namanya 'Zonk'
        // Gunakan where(function...) agar logika OR tidak bertabrakan dengan kondisi lain jika nanti ada tambahan
        $prizes = Prize::where(function($query) {
            $query->where('stock', '>', 0)
                  ->orWhere('name', 'like', '%Zonk%');
        })->get();

        if ($prizes->isEmpty()) {
            return response()->json(['error' => 'Maaf, semua hadiah sudah habis!'], 404);
        }

        // 2. Sistem Weighted Random
        $weightedPrizes = collect();
        foreach ($prizes as $prize) {
            // Jika Zonk, peluangnya kecil (1), jika hadiah fisik peluangnya besar (5)
            $weight = (strtolower($prize->name) === 'zonk') ? 1 : 5; 
            for ($i = 0; $i < $weight; $i++) {
                $weightedPrizes->push($prize);
            }
        }

        // 3. Tentukan Pemenang
        $winnerPrize = $weightedPrizes->random(); 

        // 4. Update Stok & Simpan Data (Gunakan pengecekan manual agar lebih akurat)
        if(strtolower($winnerPrize->name) !== 'zonk') {
            // Pastikan stok masih ada sebelum dikurangi (Double Check)
            if($winnerPrize->stock > 0) {
                $winnerPrize->decrement('stock');
            } else {
                // Jika ternyata pas di-klik stok habis, paksa jadi Zonk
                $winnerPrize = Prize::where('name', 'like', '%Zonk%')->first();
            }
        }

        // 5. Catat ke tabel Participants untuk Laporan Admin
        Participant::create([
            'name' => $request->name,
            'prize_won' => $winnerPrize->name
        ]);

        return response()->json([
            'winner_name' => $request->name,
            'prize' => $winnerPrize->name
        ]);
    }

    public function adminIndex(Request $request)
    {
        // PERBAIKAN: Ganti RaffleParticipant menjadi Participant
        $query = Participant::query(); 

        // Filter berdasarkan tanggal jika ada input dari request
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        $participants = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.index', compact('participants'));
    }
}