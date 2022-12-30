<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReadingTest extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title','orderIndex',
    ];

    public function readings()
    {
        return  $this->hasMany(Reading::class,'test_id');
    }
}
