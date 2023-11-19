<?php

namespace Axis;

use Axis\Charts\Apex;
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

    /**
     * @param  array<string, mixed>  $options
     */
    public static function apex(array $options): Apex
    {
        return new Apex($options, AxisHelper::current());
    }
}
