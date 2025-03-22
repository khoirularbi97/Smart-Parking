<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plat_nomor', 'tipe_kendaraan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parkirMasuk()
    {
        return $this->hasMany(ParkirMasuk::class);
    }
}
