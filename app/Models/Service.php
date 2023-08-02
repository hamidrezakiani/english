<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = ['name','type','amount'];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getCountSuccessOrderAttribute()
    {
        return $this->orders()->paid()->count();
    }

    public function getCountOrderAttribute()
    {
        return $this->orders()->count();
    }
}
