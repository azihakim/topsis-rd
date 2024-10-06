<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianDb extends Model
{
    use HasFactory;
    protected $table = 'penilaian_dbs';
    protected $fillable = ['periode', 'data'];
}
