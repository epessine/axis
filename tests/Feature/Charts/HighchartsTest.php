<?php

use Axis\Charts\Highcharts;
use Axis\Support\Script;

test('it should properly parse to javascript', function () {
    $options = [
        'chart' => ['type' => 'bar'],
        'title' => ['text' => 'Fruit Consumption'],
        'xAxis' => [
            'categories' => ['Apples', 'Bananas', 'Oranges'],
            'labels' => ['formatter' => Script::from("(v) => v + ' meters'")],
        ],
        'yAxis' => ['title' => ['text' => 'Fruit eaten']],
        'series' => [
            ['name' => 'Jane', 'data' => [1, 0, 4]],
            ['name' => 'John', 'data' => [5, 7, 3]],
        ],
    ];

    $chart = new Highcharts($options);

    expect($chart->toJavascript())->toBe(<<<JS
    {init() {const boot =() => Highcharts.chart(this.\$refs.container, {"chart":{"type":"bar"},"title":{"text":"Fruit Consumption"},"xAxis":{"categories":["Apples","Bananas","Oranges"],"labels":{"formatter":(v) => v + ' meters'}},"yAxis":{"title":{"text":"Fruit eaten"}},"series":[{"name":"Jane","data":[1,0,4]},{"name":"John","data":[5,7,3]}]});;window.\$axis['{$chart->getId()}'] = boot();this.\$wire.clearScript();}}
    JS);
});
