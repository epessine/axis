<?php

namespace Tests;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Encryption\Encrypter;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $enablesPackageDiscoveries = true;

    protected function defineEnvironment($app)
    {
        tap($app['config'], function (Repository $config) {
            $config->set('app.key', 'base64:'.base64_encode(
                Encrypter::generateKey($config['app.cipher'])
            ));
        });
    }
}
