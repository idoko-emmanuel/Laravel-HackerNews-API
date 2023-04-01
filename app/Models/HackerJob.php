<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackerJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'by',
        'score',
        'text',
        'time',
        'title',
        'type',
        'url',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'by');
    }
}
