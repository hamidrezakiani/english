<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id','amount','code'
    ];

    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function paidOrders()
    {
       return $this->hasMany(Order::class)->paid();
    }
}
