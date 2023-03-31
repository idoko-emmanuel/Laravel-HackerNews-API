<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'title',
        'url',
        'text',
        'score',
        'by',
        'parent_id',
        'points',
        'comments_count',
        'type',
        'category',
        'time',
        'descendants',
        'deleted',
        'dead',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'by');
    }

    public function parent()
    {
        return $this->belongsTo(Story::class, 'parent_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('time');
    }
}
