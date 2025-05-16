<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'users_id',        
        'uid',
        'nama',
        'jenis',
        'jumlah',
        'CreatedBy',
        'LastUpdateBy',
        'CompanyCode',
        'Status',
        'IsDeleted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id'); 
    }
}
