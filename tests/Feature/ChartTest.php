<?php

use Axis\Attributes\Axis;
use Axis\Chart;
use Axis\Charts\ChartJs;
use Livewire\Component;

use function Pest\Livewire\livewire;

test('it should return chartjs instance with proper props', function () {
    $config = [
        'type' => 'bar',
        'data' => [
            'labels' => ['a', 'b', 'c'],
            'datasets' => [
                ['label' => 'dataset a', 'data' => [1, 2, 3], 'borderColor' => 'red'],
                ['label' => 'dataset b', 'data' => [2, 3, 5], 'borderColor' => 'green'],
                ['label' => 'dataset c', 'data' => [6, 4, 9], 'borderColor' => 'yellow'],
            ],
            'options' => [
                'responsive' => true,
            ],
        ],
    ];

    $chart = Chart::chartjs($config);

    expect(invade($chart, 'config'))->toBe($config);
});

test('it should properly set axis attribute when called on livewire context for chartjs', function () {
    $component = new class extends Component
    {
        #[Axis]
        public function chartjs(): ChartJs
        {
            return Chart::chartjs([]);
        }

        public function render(): string
        {
            return '<div></div>';
        }
    };

    $component = livewire($component::class);

    $chartjs = $component->get('chartjs');

    expect(invade($chartjs, 'attribute'))->toBeInstanceOf(Axis::class);
    expect(invade($chartjs, 'component'))->toBeInstanceOf(Component::class);
});
