<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogNotifikasi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'jenis', 'pesan', 'status', 'waktu_kirim'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
