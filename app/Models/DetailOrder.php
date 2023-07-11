<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Items;

class DetailOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function items()
    {
        return $this->belongsTo(Items::class, 'items_id');
    }
}
