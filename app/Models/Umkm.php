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
        'proposal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penilaians()
    {
        return $this->hasMany(PenilaianDb::class, 'umkm_id'); // Jika `umkm_id` ada di PenilaianDb
    }
}
