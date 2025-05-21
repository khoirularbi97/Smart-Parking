<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
     protected $fillable = ['name', 'is_available'];

    public function histories() {
        return $this->hasMany(RiwayatParkir::class);
    }
}
