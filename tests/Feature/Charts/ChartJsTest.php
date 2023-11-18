<?php

use Axis\Charts\ChartJs;

test('it should properly parse to javascript', function () {
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

    $chart = new ChartJs($config);

    expect($chart->toJavascript())->toBe("{init() {window.\$axis['{$chart->getId()}'] =new Chart(this.\$refs.container, JSON.parse('{\u0022type\u0022:\u0022bar\u0022,\u0022data\u0022:{\u0022labels\u0022:[\u0022a\u0022,\u0022b\u0022,\u0022c\u0022],\u0022datasets\u0022:[{\u0022label\u0022:\u0022dataset a\u0022,\u0022data\u0022:[1,2,3],\u0022borderColor\u0022:\u0022red\u0022},{\u0022label\u0022:\u0022dataset b\u0022,\u0022data\u0022:[2,3,5],\u0022borderColor\u0022:\u0022green\u0022},{\u0022label\u0022:\u0022dataset c\u0022,\u0022data\u0022:[6,4,9],\u0022borderColor\u0022:\u0022yellow\u0022}],\u0022options\u0022:{\u0022responsive\u0022:true}}}'));;this.\$wire.clearScript();}}");
});
