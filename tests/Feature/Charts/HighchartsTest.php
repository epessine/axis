<?php

use Axis\Charts\Highcharts;
use Axis\Support\Script;
use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Process;

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

test('it should run process to create png', function () {
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

    Process::fake();

    $chart = new Highcharts($options);

    $chart->toPng(250, 250);

    Process::assertRan(function (PendingProcess $process) use ($chart) {
        $command = str($process->command);

        return $command->contains(str(minify(invadeCall($chart, 'bootScript')))
            ->replace('$container', 'window.chartContainer')
            ->replace('"', '\'')
            ->toString())
            && $command->contains(invade($chart, 'nodeBinary'))
            && $command->contains(invade($chart, 'includePath'))
            && $command->contains('puppeteer.launch')
            && $command->contains('png');
    });
});

test('it should run process to create jpeg', function () {
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

    Process::fake();

    $chart = new Highcharts($options);

    $chart->toJpeg(250, 250);

    Process::assertRan(function (PendingProcess $process) use ($chart) {
        $command = str($process->command);

        return $command->contains(str(minify(invadeCall($chart, 'bootScript')))
            ->replace('$container', 'window.chartContainer')
            ->replace('"', '\'')
            ->toString())
            && $command->contains(invade($chart, 'nodeBinary'))
            && $command->contains(invade($chart, 'includePath'))
            && $command->contains('puppeteer.launch')
            && $command->contains('jpeg');
    });
});

test('it should run process to create webp', function () {
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

    Process::fake();

    $chart = new Highcharts($options);

    $chart->toWebp(250, 250);

    Process::assertRan(function (PendingProcess $process) use ($chart) {
        $command = str($process->command);

        return $command->contains(str(minify(invadeCall($chart, 'bootScript')))
            ->replace('$container', 'window.chartContainer')
            ->replace('"', '\'')
            ->toString())
            && $command->contains(invade($chart, 'nodeBinary'))
            && $command->contains(invade($chart, 'includePath'))
            && $command->contains('puppeteer.launch')
            && $command->contains('webp');
    });
});
