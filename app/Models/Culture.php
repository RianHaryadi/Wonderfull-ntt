<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Culture extends Model
{
    protected $fillable = [
        'title',
        'description_1',
        'description_2',
        'tags',
        'image',
    ];

    protected $casts = [
        'tags' => 'array',
    ];
}
