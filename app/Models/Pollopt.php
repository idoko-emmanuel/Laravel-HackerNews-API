<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
