<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'harga',
        'stock',
        'slug',
        'status',
        'kategori',
    ];

    protected $table = 'food';
}
