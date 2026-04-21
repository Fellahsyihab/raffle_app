<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    // Izinkan kolom ini diisi secara massal
    protected $fillable = ['name', 'stock', 'chance'];
}