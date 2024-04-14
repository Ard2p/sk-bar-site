<?php

namespace App\Models;

use App\Models\Seo;
use App\Enums\EventStatusEnum;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Layouts\Casts\LayoutsCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'banner',
        'gallery',
        'description',
        'guest_start',
        'event_start',
        'recommendation',
        'status',
        'age_limit',
        'place_id',
        'genre_id'
        // 'adress',
        // 'city_id'
    ];

    protected $with = ['place'];

    protected function casts(): array
    {
        return [
            'guest_start' => 'datetime',
            'event_start' => 'datetime',
            // 'gallery' => LayoutsCast::class,
        ];
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'model');
    }

    public function scopeRecommendation(Builder $query): void
    {
        $query->where('recommendation', 1);
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereNot('status', EventStatusEnum::DRAFT);
    }
}
