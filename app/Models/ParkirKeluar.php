<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkirKeluar extends Model
{
    use HasFactory;

    protected $fillable = ['parkir_masuk_id', 'waktu_keluar', 'durasi', 'biaya', 'metode_pembayaran', 'status_pembayaran'];

    public function parkirMasuk()
    {
        return $this->belongsTo(ParkirMasuk::class);
    }
    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }
}
