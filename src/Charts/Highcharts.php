<?php

namespace Axis\Charts;

use Axis\Enums\Type;
use Axis\Interfaces\Javascriptable;
use Axis\Interfaces\Renderable;
use Axis\Traits\AsAxisChart;
use Illuminate\Contracts\Support\Htmlable;
use Serializable;

final class Highcharts implements Htmlable, Javascriptable, Renderable, Serializable
{
    use AsAxisChart;

    private function getPackageName(): string
    {
        return 'highcharts';
    }

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

    public function title(string $title): static
    {
        data_set($this->config, 'title.text', $title);

        return $this;
    }

    /**
     * @param  iterable<string>  $labels
     */
    public function labels(iterable $labels): static
    {
        data_set($this->config, 'xAxis.categories', [...$labels]);

        return $this;
    }

    public function type(Type $type): static
    {
        if ($type === Type::Radar) {
            data_set($this->config, 'chart.polar', true);
        }

        $type = match ($type) {
            Type::Line,
            Type::Radar => 'line',
            Type::Bar => 'bar',
            Type::Column => 'column',
            Type::Pie => 'pie',
        };

        data_set($this->config, 'chart.type', $type);

        return $this;
    }

    /**
     * @param  iterable<mixed, mixed>  $options
     */
    public function options(iterable $options, bool $overwrite = false): static
    {
        /** @var array<string, mixed> $currentOptions */
        $currentOptions = $this->config ?? [];

        $options = $overwrite
            ? [...$options]
            : array_replace_recursive($currentOptions, [...$options]);

        $this->config = ['series' => $this->config['series'], ...$options];

        return $this;
    }

    /**
     * @param  iterable<int|iterable<int>>  $data
     * @param  iterable<mixed, mixed>  $options
     */
    public function series(string $name, iterable $data, iterable $options = []): static
    {
        $series = ['data' => [...$data], 'name' => $name, ...$options];

        /** @var array<array<string, mixed>> $currentSeries */
        $currentSeries = $this->config['series'] ?? [];

        $currentSeries[] = $series;

        data_set($this->config, 'series', $currentSeries);

        return $this;
    }

    private function prepareForScreenshot(): void
    {
        data_set($this->config, 'chart.animation', false);
        data_set($this->config, 'plotOptions.series.animation', false);
    }
}
