<?php

namespace Chartwire;

use Chartwire\Attributes\Chartwire;
use Chartwire\Charts\ChartJs;

final class Chart
{
    public static function chartjs(array $config): ChartJs
    {
        /** @var ?Chartwire $attribute */
        $attribute = collect(debug_backtrace())->firstWhere(
            fn (array $trace): bool => data_get($trace, 'object') instanceof Chartwire
        )['object'];

        return new ChartJs($config, $attribute);
    }
}
