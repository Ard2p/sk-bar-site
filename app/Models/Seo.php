<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Leeto\Seo\Casts\UrlCast;

class Seo extends Model
{
    use HasFactory;

    protected $table = 'seo';

    protected $fillable = [
        'url',
        'title',
        'description',
        'keywords',
        'text',
        'model_id',
        'model_type',
    ];

    protected $casts = [
        'url' => UrlCast::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(static fn (Seo $model) => $model->flushCache());
        static::updated(static fn (Seo $model) => $model->flushCache());
        static::deleting(static fn (Seo $model) => $model->flushCache());
    }

    public function flushCache(): void
    {
        seo()->flushCache(
            seo()->getCacheKey($this->url)
        );
    }
}
