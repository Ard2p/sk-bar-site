<?php

namespace App\Jobs;

use App\Services\VkService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class VKAlbumsUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 999999999;

    public $maxExceptions = 3;

    protected $ownerId = null;
    protected $albumId = null;

    public function middleware(): array
    {
        return [new RateLimited('VKAlbumsUpdate')];
    }

    public function __construct($ownerId, $albumId)
    {
        $this->ownerId = $ownerId;
        $this->albumId = $albumId;
    }

    public function handle(VkService $vkService): void
    {
        $vkService->createCachePhotos($this->ownerId, $this->albumId);
    }

    public function uniqueId(): string
    {
        return $this->ownerId . ':' . $this->albumId;
    }
}
