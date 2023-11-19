<?php

namespace Axis\Charts;

use Axis\Interfaces\Javascriptable;
use Axis\Interfaces\Renderable;
use Axis\Traits\AsAxisChart;
use Illuminate\Contracts\Support\Htmlable;
use Serializable;

final class Apex implements Htmlable, Javascriptable, Renderable, Serializable
{
    use AsAxisChart;

    public function getContainerElement(): string
    {
        return 'div';
    }

    protected function bootScript(): string
    {
        return <<<JS
            () => {
                const chart = new ApexCharts(\$container, {$this->js($this->config)});
                chart.render();
                return chart;
            }
        JS;
    }

    protected function updateScript(): string
    {
        return <<<JS
            () => \$chart.updateOptions({$this->js($this->config)});
        JS;
    }
}
