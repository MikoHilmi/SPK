<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crips extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'bobot',
        'kriteria_id',
    ];
    protected $table = 'crips';
}
