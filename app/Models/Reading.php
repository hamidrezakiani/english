<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'test_id','text','translate','orderIndex'
    ];

    public function test()
    {
        return $this->belongsTo(ReadingTest::class,'test_id','id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class,'foreign_id')->where('type','READING_TEST');
    }
}
