---
title: "Chart.js"
weight: 1
prev: /docs/drawing-charts
next: false
---

{{< callout >}}
  In this section we will reproduce the same chart as the [Getting Started](https://www.chartjs.org/docs/latest/getting-started/) section of the Chart.js docs.
{{< /callout >}}

After installing [Axis](/docs/installation) and [Chart.js](https://www.chartjs.org/docs/latest/getting-started/installation.html), we can instantiate a chart object and pass it to a view on a controller:

```php
use Axis\Chart;

class ExampleController extends Controller
{
    public function __invoke(): View
    {
        $chart = Chart::chartjs([
            'type' => 'bar',
            'data' => [
                'labels' => ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                'datasets' => [[
                    'label' => '# of Votes',
                    'data' => [12, 19, 3, 5, 2, 3],
                    'borderWidth' => 1,
                ]],
            ],
            'options' => [
                'scales' => [
                    'y' => ['beginAtZero' => true],
                ]
            ]
        ]);

        return view('example.chart', compact('chart'));
    }
}
```

On the blade file:

```html
<section>
    <div>{{ $chart }}</div>
</section>
```

You should get a chart like this:

![](https://www.chartjs.org/docs/latest/assets/img/preview.0cc909a8.png)

Pretty simple, right?