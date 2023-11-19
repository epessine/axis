<?php

use Axis\Charts\Apex;
use Axis\Support\Script;

test('it should properly parse to javascript', function () {
    $options = [
        'chart' => ['type' => 'line'],
        'series' => [[
            'name' => 'sales',
            'data' => [30, 40, 35, 50, 49, 60, 70, 91, 125],
        ]],
        'xaxis' => [
            'categories' => [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999],
            'labels' => ['formatter' => Script::from("(v) => v + ' meters'")],
        ],
    ];

    $chart = new Apex($options);

    expect($chart->toJavascript())->toBe(<<<JS
    {init() {const boot =() => {const chart = new ApexCharts(this.\$refs.container, {"chart":{"type":"line"},"series":[{"name":"sales","data":[30,40,35,50,49,60,70,91,125]}],"xaxis":{"categories":[1991,1992,1993,1994,1995,1996,1997,1998,1999],"labels":{"formatter":(v) => v + ' meters'}}});chart.render();return chart;};window.\$axis['{$chart->getId()}'] = boot();this.\$wire.clearScript();}}
    JS);
});
