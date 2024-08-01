<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserv extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'table',
        'status',
        'phone',
        'seats',
        'name'
    ];

    // protected $with = ['event'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
