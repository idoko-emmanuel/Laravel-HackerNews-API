<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'created',
        'karma',
        'about',
        'submitted',
    ];

    protected $casts = [
        'submitted' => 'json',
    ];

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function jobs()
    {
        return $this->hasMany(Story::class);
    }
}
