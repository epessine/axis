<?php

namespace Chartwire;

use Chartwire\Datasets\Bar;
use Chartwire\Datasets\Base;

/**
 * @mixin \Chartwire\Datasets\Base
 */
class Dataset
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
