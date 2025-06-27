<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkirMasuk extends Model
{
    use HasFactory;

    protected $fillable = ['kendaraan_id', 'waktu_masuk', 'lokasi_parkir', 'status'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }
}
