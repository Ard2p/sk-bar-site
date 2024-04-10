<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'banner',
        'description',
        'guest_start',
        'event_start',
        'status',
        'age_limit',
        'place_id'
        // 'adress',
        // 'city_id'
    ];

    protected $with = ['place'];

    protected function casts(): array
    {
        return [
            'guest_start' => 'datetime',
            'event_start' => 'datetime',
        ];
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
