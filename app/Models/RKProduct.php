<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
