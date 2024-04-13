<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seo extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'model_id',
        'model_type',
        'seo',
    ];

    protected function casts(): array
    {
        return [
            'seo' => 'array',
        ];
    }
}
