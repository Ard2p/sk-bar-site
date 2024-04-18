<?php

namespace App\Models;


use App\Enums\EventStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'link',
        'status',
    ];

    public function scopeActive(Builder $query): void
    {
        $query->whereNot('status', SliderStatusEnum::DRAFT);
    }
}
