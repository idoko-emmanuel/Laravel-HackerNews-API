<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'by',
        'descendants',
        'score',
        'title',
        'text',
        'time',
    ];

    public function pollOptions()
    {
        return $this->hasMany(Pollopt::class);
    }

    public function comment()
    {
        return $this->morphOne(Comment::class, 'commentable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
