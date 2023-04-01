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

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function orderable()
    {
        return $this->morphTo();
    }
}
