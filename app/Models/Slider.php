<?php

namespace App\Models;


use Carbon\Carbon;
use App\Enums\EventStatusEnum;
use App\Enums\SliderStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'slider';

    protected $fillable = [
        'name',
        'image',
        'link',
        'status',
        'date_from',
        'date_to',
    ];

    protected function casts(): array
    {
        return [
            'date_from' => 'datetime',
            'date_to' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereNot('status', SliderStatusEnum::DRAFT);
    }

    public function scopePeriod(Builder $query): void
    {
        $query->where(fn ($q) => $q->where('date_from', '<=', Carbon::now()->toDateTimeString())->orWhereNull('date_from'));
        $query->where(fn ($q) => $q->where('date_to', '>=', Carbon::now()->toDateTimeString())->orWhereNull('date_to'));
    }
}
