<?php

namespace App\Models;

use Database\Factories\PolloptFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pollopt extends Model
{
    use HasFactory;

    protected $fillable = [
        'by',
        'poll_id',
        'score',
        'text',
        'time',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PolloptFactory::new();
    }
}
