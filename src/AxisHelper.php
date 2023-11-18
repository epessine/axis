<?php

namespace Axis;

use Axis\Attributes\Axis;

final class AxisHelper
{
    public static function current(): ?Axis
    {
        return data_get(collect(debug_backtrace())->first(
            fn (array $trace): bool => data_get($trace, 'object') instanceof Axis
        ), 'object');
    }
}
