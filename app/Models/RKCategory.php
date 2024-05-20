<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
