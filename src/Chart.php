<?php

namespace Chartwire;

use Chartwire\Charts\Bar;
use Chartwire\Charts\Base;

/**
 * @mixin \Chartwire\Charts\Base
 */
class Chart
{
    public static function bar(): Bar
    {
        return new Bar;
    }

    public static function __callStatic($name, $arguments)
    {
        return (new Base)->{$name}($arguments);
    }
}
