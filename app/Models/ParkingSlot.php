<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
     protected $fillable = ['name', 'user_id','is_available'];

    public function histories() {
        return $this->hasMany(RiwayatParkir::class);
    }
    public function user() {
        return $this->hasMany(User::class);
    }
    public function riwayatParkir()
{
    return $this->hasMany(\App\Models\RiwayatParkir::class, 'parking_slot_id');
}

}
