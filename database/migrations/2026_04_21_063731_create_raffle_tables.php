<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Hadiah
        Schema::create('prizes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Hadiah (Stiker, Tumbler, Zonk)
            $table->integer('stock')->default(0); // Jumlah Stok
            $table->integer('chance')->default(1); // Bobot peluang (1-100)
            $table->timestamps();
        });

        // Tabel Peserta/Pemenang
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('prize_won')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prizes');
        Schema::dropIfExists('participants');
    }
};
