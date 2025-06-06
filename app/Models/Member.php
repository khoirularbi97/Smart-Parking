<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'nama', 'UID', 'saldo'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
