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
        'name'
    ];

    // protected $with = ['events'];

    public function events()
    {
        return $this->belongsTo(Event::class);
    }
}
