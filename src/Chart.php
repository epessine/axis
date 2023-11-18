<?php

namespace Axis;

use Axis\Charts\ChartJs;

final class Chart
{
    /**
     * @param  array<string, mixed>  $config
     */
    public static function chartjs(array $config): ChartJs
    {
        return new ChartJs($config, AxisHelper::current());
    }
}
