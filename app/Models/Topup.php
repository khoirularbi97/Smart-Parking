<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{   protected $fillable = [
    'users_id',
    'amount',
    'name',
    'alamat',
    'method',
    'status',
    'order_id' 
];

   public function user()
{
    return $this->belongsTo(User::class, 'users_id');
}

// Topup.php
public $timestamps = true; // default-nya true, jadi cukup hilangkan manual set created_at/updated_at


}
