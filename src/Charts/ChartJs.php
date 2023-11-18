<?php

namespace Axis\Charts;

use Axis\Interfaces\Javascriptable;
use Axis\Interfaces\Renderable;
use Axis\Traits\AsAxisChart;
use Illuminate\Contracts\Support\Htmlable;
use Serializable;

final class ChartJs implements Htmlable, Javascriptable, Renderable, Serializable
{
    use AsAxisChart;

    protected function bootScript(): string
    {
        return <<<JS
            new Chart(\$container, {$this->js($this->config)});
        JS;
    }

    protected function updateScript(): string
    {
        return <<<JS
            \$chart.data = {$this->js($this->config)}.data;
            \$chart.update();
        JS;
    }
}
