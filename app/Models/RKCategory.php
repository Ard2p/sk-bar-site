<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RKCategory extends Model
{
    use HasFactory;

    protected $table = 'rk_categories';

    protected $fillable = [
        'ident',
        'code',
        'name',
        'position' // sort_order
    ];

    protected $with = ['products'];

    public function products()
    {
        return $this->hasMany(RKProduct::class, 'parent_ident', 'ident');
    }

    public function scopeOrder(Builder $query): void
    {
        $query->orderBy(DB::raw('ISNULL(position), position'), 'ASC');
    }
}
