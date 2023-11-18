<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $enablesPackageDiscoveries = true;

    protected function defineEnvironment($app)
    {
        tap($app['config'], fn () => Artisan::call('key:generate'));
    }
}
