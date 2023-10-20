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
        'user_id','type','payable','discount_id','service_id'
    ];

    public function scopePaid(Builder $query): void
    {
        $query->where('status', 'PAID');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
