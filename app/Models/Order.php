<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id','type','amount','discount_id','payable'
    ];

    public function scopePaid(Builder $query): void
    {
        $query->where('status', 'PAID');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
