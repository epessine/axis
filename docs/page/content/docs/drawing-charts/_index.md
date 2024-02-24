---
title: Drawing Charts
weight: 2
prev: /docs/installation
next: /docs/interacting-with-charts
sidebar:
    open: true
---

### Concept

Drawing charts with Axis is ultra-easy. You just instantiate a chart class that can be rendered on views, and Axis handles everything to draw the chart for you:

```php
use Axis\Chart;

class ExampleController extends Controller
{
    public function __invoke(): View
    {
        $chart = Chart::chartjs()
            ->bar()
            ->labels(['A', 'B', 'C'])
            ->series('First Series', [10, 20, 30]);

        return view('example.chart', compact('chart'));
    }
}
```

On the blade file:

```html
<section>
    <h1>Example Chart</h1>
    <div>{{ $chart }}</div>
</section>
```

And _voilà_, the chart is rendered for you!

### Scriptable properties

Many chart libraries offer the possibility to set config properties as functions, to set dynamic behavior. Axis provides a `Script` helper that lets you insert Javascript functions directly on the PHP config array.

In the example below, we create a scriptable `backgroundColor` for a dataset on Chart.js that sets the color as `red` when the number is below 10, or `green` otherwise:

```php
use Axis\Chart;
use Axis\Support\Script;

class ExampleController extends Controller
{
    public function __invoke(): View
    {
        $chart = Chart::chartjs()
            ->bar()
            ->labels(['A', 'B', 'C'])
            ->series('First Series', [10, 20, 30], [
                'backgroundColor' => Script::from(<<<'JS'
                    function(ctx) {
                        const index = ctx.dataIndex;
                        const value = ctx.dataset.data[index];
                        return value < 10 ? 'red' :  'green';
                    }
                JS),
            ]);

        return view('example.chart', compact('chart'));
    }
}
```

### Using raw data

You can also create charts using the same JS API from your chosen library. This is useful if you want to create charts with high levels of customization. Here's how you can do it to create the same chart as the first one on this section:

```php
use Axis\Chart;

class ExampleController extends Controller
{
    public function __invoke(): View
    {
        $chart = Chart::chartjs([
            'type' => 'bar',
            'data' => [
                'labels' => ['A', 'B', 'C'],
                'datasets' => [
                    ['label' => 'First Dataset', 'data' => [10, 20, 30]],
                ],
            ],
        ]);

        return view('example.chart', compact('chart'));
    }
}
```

### Examples

Explore the following sections to learn how to draw your first chart, depending on what library you're using:

<!--more-->

{{< cards >}}
{{< card link="chart-js" title="Chart.js" >}}
{{< card link="apex-charts" title="Apex Charts" >}}
{{< card link="highcharts" title="Highcharts" >}}
{{< /cards >}}
