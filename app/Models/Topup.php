<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{   protected $fillable = [
    'user_id',
    'amount',
    'status',
    'order_id' // jika ada kolom status juga
    // tambahkan lainnya jika perlu
];

   public function user()
{
    return $this->belongsTo(User::class);
}

}
