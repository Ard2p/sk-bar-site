<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain'
    ];

    protected $with = ['places'];

    public function places()
    {
        return $this->belongsToMany(Place::class);
    }

    public function scopeDomain(Builder $query, $domain)
    {
        return $query->where('domain', 'LIKE', '%' .  $domain . '%');
    }
}
