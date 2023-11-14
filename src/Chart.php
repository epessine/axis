<?php

namespace Axis;

use Axis\Attributes\Axis;
use Axis\Charts\ChartJs;

final class Chart
{
    public static function chartjs(array $config): ChartJs
    {
        /** @var ?Axis $attribute */
        $attribute = collect(debug_backtrace())->firstWhere(
            fn (array $trace): bool => data_get($trace, 'object') instanceof Axis
        )['object'];

        return new ChartJs($config, $attribute);
    }
}
