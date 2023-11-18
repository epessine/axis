<?php

use Axis\Charts\ChartJs;
use Axis\Support\Script;

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
                'onClick' => Script::from('(e) => console.log(e)'),
            ],
        ],
    ];

    $chart = new ChartJs($config);

    expect($chart->toJavascript())->toBe(<<<JS
    {init() {const boot =() => new Chart(this.\$refs.container, {"type":"bar","data":{"labels":["a","b","c"],"datasets":[{"label":"dataset a","data":[1,2,3],"borderColor":"red"},{"label":"dataset b","data":[2,3,5],"borderColor":"green"},{"label":"dataset c","data":[6,4,9],"borderColor":"yellow"}],"options":{"responsive":true,"onClick":(e) => console.log(e)}}});;window.\$axis['{$chart->getId()}'] = boot();this.\$wire.clearScript();}}
    JS);
});
