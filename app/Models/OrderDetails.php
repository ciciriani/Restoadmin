<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    public function food()
    {
        return $this->belongsTo(Foods::class, 'id_food', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Orders::class, 'id_order', 'id');
    }
}
