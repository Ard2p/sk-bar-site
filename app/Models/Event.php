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
        'description',
        'date_start',
        'status',
        'age_limit',
        'adress',
        'city_id'
    ];

    public function city()
    {
        return $this->hasOne(City::class);
    }
}
