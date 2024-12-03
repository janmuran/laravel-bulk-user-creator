<?php

declare(strict_types=1);

namespace Janmuran\LaravelBulkUserCreator\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Janmuran\LaravelBulkUserCreator\PkgAdminCreatorServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            PkgAdminCreatorServiceProvider::class,
        ];
    }
}