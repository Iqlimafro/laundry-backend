<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order;
use App\Models\Items;

class Laundries extends Model
{
    use HasFactory;

    protected $table = 'laundries';
    protected $guarded = ['id'];

    // public function users()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function laundries()
    {
        return $this->belongsTo(Laundries::class, 'laundry_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function items()
    {
        return $this->hasMany(Items::class);
    }
}
