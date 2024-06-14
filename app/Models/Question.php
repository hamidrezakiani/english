<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'foreign_id','question','translate','solve','orderIndex','type',
    ];

    protected static function booted () {
        static::deleting(function(Question $question) { // before delete() method call this
             $question->answers()->delete();
             // do the rest of the cleanup...
        });
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
