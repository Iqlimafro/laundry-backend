<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Laundries;
use App\Models\User;
use App\Models\Order;

class Reviews extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laundries()
    {
        return $this->belongsTo(Laundries::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
