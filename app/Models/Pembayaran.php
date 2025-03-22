<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';
    protected $fillable = ['parkir_keluar_id', 'total_bayar', 'metode_pembayaran', 'status', 'waktu_pembayaran'];
    

    public function parkirKeluar()
    {
        return $this->belongsTo(ParkirKeluar::class);
    }
}

