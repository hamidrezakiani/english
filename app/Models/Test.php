<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title','type','index','reading',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function scopeWordTests($query)
    {
        return $query->where('type','WORD');
    }

    public function scopeReadingTests($query)
    {
        return $query->where('type','READING');
    }

}
