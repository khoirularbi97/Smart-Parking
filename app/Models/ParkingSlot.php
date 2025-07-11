<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
     protected $fillable = ['name','users_id','is_available'];

    public function histories() {
        return $this->hasMany(RiwayatParkir::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }


    public function riwayatParkir()
{
    return $this->hasMany(\App\Models\RiwayatParkir::class, 'parking_slot_id');
}

}
