<?php

declare(strict_types=1);

namespace Janmuran\LaravelBulkUserCreator;

use Illuminate\Support\ServiceProvider;
use Janmuran\LaravelBulkUserCreator\Command\CreateUsersCommand;

class PkgAdminCreatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            CreateUsersCommand::class,
        ]);
    }
}
