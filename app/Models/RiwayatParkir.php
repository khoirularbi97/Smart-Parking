<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatParkir extends Model
{
    use HasFactory;

    protected $fillable = ['parking_slot_id', 'user_id', 'tanggal', 'total_durasi', 'total_biaya', 'jumlah_transaksi'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
     public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function parking_slot() {
        return $this->belongsTo(ParkingSlot::class);
    }
}
