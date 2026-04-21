<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prize;

class AdminController extends Controller
{
    public function index() {
        // Mengambil data prizes untuk ditampilkan di tabel
        $prizes = Prize::all();
        // Pastikan file ada di resources/views/admin/dashboard.blade.php
        return view('admin.dashboard', compact('prizes'));
    }

    public function updateStock(Request $request, $id) {
        $prize = Prize::findOrFail($id);
        $prize->update(['stock' => $request->stock]);
        return back()->with('success', 'Stok berhasil diperbarui!');
    }

    public function store(Request $request) {
        Prize::create($request->only(['name', 'stock']));
        return back()->with('success', 'Hadiah baru ditambahkan!');
    }
}