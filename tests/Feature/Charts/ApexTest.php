<?php

use Axis\Charts\Apex;
use Axis\Support\Script;
use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Process;

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

test('it should run process to create png', function () {
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

    Process::fake();

    $chart = new Apex($options);

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

    Process::fake();

    $chart = new Apex($options);

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

    Process::fake();

    $chart = new Apex($options);

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
