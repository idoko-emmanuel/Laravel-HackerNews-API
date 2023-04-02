<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'text',
        'parent_id',
        'points',
        'by',
    ];
    
    public function author()
    {
        return $this->belongsTo(Author::class, 'by');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function comment()
    {
        return $this->morphOne(self::class, 'commentable');
    }

    public function comments()
    {
        return $this->morphMany(self::class, 'commentable');
    }
}
