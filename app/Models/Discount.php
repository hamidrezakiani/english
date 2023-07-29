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
        $this->belongsTo(User::class);
    }

    public function orders()
    {
        $this->hasMany(Order::class);
    }

    public function paidOrders()
    {
        $this->hasMany(Order::class)->paid();
    }
}
