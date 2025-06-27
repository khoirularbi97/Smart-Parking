<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatParkir extends Model
{
    use HasFactory;

    protected $fillable = ['parking_slot_id', 'parking_masuk_id', 'users_id', 'uid', 'waktu_masuk', 'image_masuk', 'waktu_keluar', 'image_keluar', 'durasi', 'biaya'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
     public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function parking_slot() {
        return $this->belongsTo(ParkingSlot::class, 'parking_slot_id');
    }
    // app/Models/RiwayatParkir.php
    public function getStatusLabelAttribute()
    {
        return $this->status == 1 ? 'Aktif' : 'Selesai';
    }

}
