<?php

namespace Axis\Charts;

use Axis\Interfaces\Javascriptable;
use Axis\Interfaces\Renderable;
use Axis\Traits\AsAxisChart;
use Illuminate\Contracts\Support\Htmlable;
use Serializable;

final class Highcharts implements Htmlable, Javascriptable, Renderable, Serializable
{
    use AsAxisChart;

    public function getContainerElement(): string
    {
        return 'div';
    }

    protected function bootScript(): string
    {
        return <<<JS
            () => Highcharts.chart(\$container, {$this->js($this->config)});
        JS;
    }

    protected function updateScript(): string
    {
        return <<<JS
            () => {
                \$chart.update({$this->js($this->config)}, true, true);
            }
        JS;
    }
}
