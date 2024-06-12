<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RKProduct extends Model
{
    use HasFactory;

    protected $table = 'rk_products';

    protected $fillable = [
        'ident',
        'code',
        'name',
        'price',
        'instruct',
        'parent_ident',
        'position' // sort_order
    ];

    public function scopeOrder(Builder $query): void
    {
        $query->orderBy(DB::raw('ISNULL(rk_products.position), rk_products.position'));
    }

    public function products()
    {
        return $this->belongsTo(RKCategory::class, 'ident', 'parent_ident')->order();
    }
}
