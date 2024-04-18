<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeneratePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate permissions';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // MenuRBAC::menu();

        $resources = moonshine()->getResources();

        foreach ($resources as $resource) {
            $resourceName = class_basename($resource::class);
            foreach ($resource->gateAbilities() as $ability) {
                config('permission.models.permission')::updateOrCreate([
                    'name' => "$resourceName.$ability",
                    'guard_name' => config('moonshine.auth.guard')
                ]);
            }
            $this->info("Permissions created successfully for $resourceName.");
        }

        app()['cache']->forget('spatie.permission.cache');

        return 0;
    }
}
