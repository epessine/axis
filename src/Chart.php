<?php

namespace Axis;

use Axis\Attributes\Axis;
use Axis\Charts\ChartJs;

final class Chart
{
    /**
     * @param  array<string, mixed>  $config
     */
    public static function chartjs(array $config): ChartJs
    {
        /** @var ?Axis $attribute */
        $attribute = data_get(collect(debug_backtrace())->first(
            fn (array $trace): bool => data_get($trace, 'object') instanceof Axis
        ), 'object');

        return new ChartJs($config, $attribute);
    }
}
