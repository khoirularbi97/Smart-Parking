<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaksi;
use App\Models\RiwayatParkir;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uid',
        'saldo',
        'CreatedBy',
        'CompanyCode' ,
        'Status' , 
        'IsDeleted',
        'LastUpdateBy'
    ];
    
    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }
    public function histories() {
    return $this->hasMany(\App\Models\RiwayatParkir::class, 'users_id');
    }   
    
  
public function transaksis()
{
    return $this->hasMany(Transaksi::class, 'users_id');
}
public function masuk()
{
    return $this->hasMany(ParkirMasuk::class, 'users_id');
}
public function keluar()
{
    return $this->hasMany(ParkirKeluar::class, 'users_id');
}
public function parking()
{
    return $this->hasMany(RiwayatParkir::class, 'users_id');
}
public function topup()
{
    return $this->hasMany(Topup::class, 'users_id');
}

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
}
