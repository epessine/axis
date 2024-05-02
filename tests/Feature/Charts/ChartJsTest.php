<?php

use Axis\Charts\ChartJs;
use Axis\Support\Script;
use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Process;

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

test('it should run process to create png', function () {
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

    Process::fake();

    $chart = new ChartJs($config);

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

    Process::fake();

    $chart = new ChartJs($config);

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

    Process::fake();

    $chart = new ChartJs($config);

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
