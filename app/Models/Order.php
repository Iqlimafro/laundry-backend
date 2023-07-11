<?php

namespace App\Models;

use App\Models\User;
use App\Models\Laundries;
use App\Models\Reviews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function laundries()
    {
        return $this->belongsTo(Laundries::class,'laundry_id');
    }

    public function review()
    {
        return $this->hasMany(Reviews::class);
    }
    public function detailOrder()
    {
        return $this->hasMany(DetailOrder::class);
    }
}
