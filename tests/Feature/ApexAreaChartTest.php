<?php

require_once __DIR__.'/../Pest.php';

use Axis\Chart;
use Axis\Enums\Type;

test('it creates an Apex area chart with correct config', function () {
    $chart = Chart::apex()
        ->type(Type::Area)
        ->title('Test Area Chart')
        ->labels(['Jan', 'Feb', 'Mar'])
        ->series('Sales', [12, 23, 45]);

    $config = invade($chart, 'config');

    expect($config['chart']['type'])->toBe('area');
    expect($config['title']['text'])->toBe('Test Area Chart');
    expect($config['xaxis']['categories'])->toBe(['Jan', 'Feb', 'Mar']);
    expect($config['series'][0]['name'])->toBe('Sales');
    expect($config['series'][0]['data'])->toBe([12, 23, 45]);
});
