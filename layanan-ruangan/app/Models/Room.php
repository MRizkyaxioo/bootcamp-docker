<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Daftar kolom yang boleh diisi secara massal
    protected $fillable = [
        'name',
        'capacity',
        'facilities',
    ];
    
}
