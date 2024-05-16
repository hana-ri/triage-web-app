<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Permission as MiddlewarePermission;

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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating permissions...');

        $routeCollection = collect(Route::getRoutes())->reject(function ($route) {
            $middlewares = $route->middleware();
            return !in_array(MiddlewarePermission::class, $middlewares);
        });

        foreach ($routeCollection as $item) {
            $name = $item->action;
            if (!empty($name['as'])) {
                $permission = $name['as'];
                $permission = trim(strtolower($permission));
                $permission = preg_replace('/[\s.,\-]+/', '.', $permission);
                $createdPermission = Permission::firstOrCreate(['name' => $permission]);
                if ($createdPermission->wasRecentlyCreated) {
                    $this->info("Permission {$permission} created.");
                } else {
                    $this->info("Permission {$permission} already exists.");
                }
            }
        }

        $this->info('Permissions generated successfully.');
    }
}
