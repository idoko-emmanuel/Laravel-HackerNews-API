<?php

namespace App\Models;

use Database\Factories\JobFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HackerJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
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

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return JobFactory::new();
    }
}
