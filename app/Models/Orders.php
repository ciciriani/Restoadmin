<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    public $table = 'orders';

    protected $fillable = [
        'nama_pelanggan',
        'id_meja',
        'id_food',
        'total_harga',
    ];

    public function food()
    {
        return $this->belongsTo(Foods::class, 'id_food', 'id');
    }

    public function table()
    {
        return $this->belongsTo(Tables::class, 'id_meja', 'id');
    }
}
