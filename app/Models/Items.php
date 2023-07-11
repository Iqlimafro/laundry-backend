<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailOrder;
use App\Models\Laundries;

class Items extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function laundries()
    {
        return $this->belongsTo(Laundries::class);
    }
    public function detailOrder()
    {
        return $this->hasMany(DetailOrder::class);
    }
}
