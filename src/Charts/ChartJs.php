<?php

namespace Axis\Charts;

use Axis\Enums\Type;
use Axis\Interfaces\Javascriptable;
use Axis\Interfaces\Renderable;
use Axis\Traits\AsAxisChart;
use Illuminate\Contracts\Support\Htmlable;
use Serializable;

final class ChartJs implements Htmlable, Javascriptable, Renderable, Serializable
{
    use AsAxisChart;

    private function getPackageName(): string
    {
        return 'chart.js';
    }

    public function getContainerElement(): string
    {
        return 'canvas';
    }

    protected function bootScript(): string
    {
        return <<<JS
            () => new Chart(\$container, {$this->js($this->config)});
        JS;
    }

    protected function updateScript(): string
    {
        return <<<JS
            () => {
                \$chart.data = {$this->js($this->config)}.data;
                \$chart.update();
            }
        JS;
    }

    public function title(string $title): static
    {
        data_set($this->config, 'options.plugins.title', [
            'text' => $title,
            'display' => true,
        ]);

        return $this;
    }

    /**
     * @param  iterable<string>  $labels
     */
    public function labels(iterable $labels): static
    {
        data_set($this->config, 'data.labels', [...$labels]);

        return $this;
    }

    public function type(Type $type): static
    {
        if ($type === Type::Bar) {
            data_set($this->config, 'options.indexAxis', 'y');
        }

        $type = match ($type) {
            Type::Bar => 'bar',
            Type::Column => 'bar',
            Type::Line => 'line',
            Type::Pie => 'pie',
            Type::Radar => 'radar',
        };

        data_set($this->config, 'type', $type);

        return $this;
    }

    /**
     * @param  iterable<mixed, mixed>  $options
     */
    public function options(iterable $options, bool $overwrite = false): static
    {
        /** @var array<string, mixed> $currentOptions */
        $currentOptions = $this->config['options'] ?? [];

        $options = $overwrite
            ? [...$options]
            : array_replace_recursive($currentOptions, [...$options]);

        data_set($this->config, 'options', $options);

        return $this;
    }

    /**
     * @param  iterable<int|iterable<int>>  $data
     * @param  iterable<mixed, mixed>  $options
     */
    public function series(string $name, iterable $data, iterable $options = []): static
    {
        $series = ['data' => [...$data], 'label' => $name, ...$options];

        /** @var array<array<string, mixed>> $currentSeries */
        $currentSeries = data_get($this->config, 'data.datasets', []);

        $currentSeries[] = $series;

        data_set($this->config, 'data.datasets', $currentSeries);

        return $this;
    }

    private function prepareForScreenshot(): void
    {
        data_set($this->config, 'options.animations', false);
    }
}
