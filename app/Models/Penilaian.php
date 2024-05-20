<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaians';
    protected $guarded = [];
    protected $fillable = ['periode_id', 'siswa_id', 'crips_id'];

    public function crips()
    {
        return $this->belongsTo(Crips::class, 'crips_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
