<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'adress',
        'content',
        'map'
    ];

    public function events()
    {
        return $this->belongsTo(Event::class);
    }
}
