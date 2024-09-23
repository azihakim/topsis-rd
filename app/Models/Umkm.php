<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'nama',
        'email',
        'alamat',
        'telepon',
        'legalitas',
        'nama_produk',
        'jenis_usaha',
        'perizinan_usaha',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
