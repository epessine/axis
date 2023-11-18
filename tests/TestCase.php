<?php

namespace Tests;

use Illuminate\Contracts\Config\Repository;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $enablesPackageDiscoveries = true;

    protected function defineEnvironment($app)
    {
        tap($app['config'], function (Repository $config) {
            $config->set('key', str()->random(16));
        });
    }
}
