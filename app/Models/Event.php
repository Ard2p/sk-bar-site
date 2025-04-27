<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Seo;
use App\Enums\EventStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
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
        'genre_id',
        'tickets_type',
        'tickets_link',
        'on_reserve'
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

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)->firstOrFail();
        // return is_numeric($value)
        //     ? $this->where('id', $value)->firstOrFail()
        //     : $this->where('slug', $value)->firstOrFail();
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {
            $query->active();
        });

        static::addGlobalScope('actual', function ($query) {
            $query->actual();
        });

        static::addGlobalScope('domain', function ($query) {
            $query->domain();
        });
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'model');
    }

    public function reservs()
    {
        return $this->hasMany(Reserv::class);
    }

    public function scopeRecommendation(Builder $query): void
    {
        $query->where('recommendation', 1);
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereNot('status', EventStatusEnum::DRAFT);
    }

    public function scopeActual(Builder $query): void
    {
        $query->whereDate('event_start', '>=', Carbon::now()->toDateString());
    }

    public function scopeArhive(Builder $query): void
    {
        $query->whereDate('event_start', '<=', Carbon::now()->toDateString());
    }

    public function scopeSkbar(Builder $query): void
    {
        $query->where('place_id', 1);
    }

    public function scopeDomain(Builder $query): void
    {
        $query->whereIn('place_id', config('domain.places') ?? []);
    }
}
