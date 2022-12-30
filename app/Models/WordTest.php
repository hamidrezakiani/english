<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WordTest extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title','orderIndex',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class,'foreign_id')->where('type','WORD_TEST');
    }

    // public function scopeWordTests($query)
    // {
    //     return $query->where('type','WORD');
    // }

    // public function scopeReadingTests($query)
    // {
    //     return $query->where('type','READING');
    // }

}
