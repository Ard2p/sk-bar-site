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
    protected $signature = 'app:generate-permissions';

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
        MenuRBAC::menu();
        $this->resourceName = $this->argument('resourceName');

        foreach (Abilities::getAbilities() as $ability) {
            config('permission.models.permission')::updateOrCreate([
                'name' => "$this->resourceName.$ability",
                'guard_name' => config('moonshine.auth.guard')
            ]);
        }

        app()['cache']->forget('spatie.permission.cache');

        $this->info("Permissions created successfully for $this->resourceName.");

        return 0;
    }
}
