<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatParkir extends Model
{
    use HasFactory;

    protected $fillable = ['kendaraan_id', 'tanggal', 'total_durasi', 'total_biaya', 'jumlah_transaksi'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
