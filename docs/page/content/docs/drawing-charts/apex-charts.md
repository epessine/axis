---
title: 'Apex Charts'
weight: 2
prev: /docs/drawing-charts
next: false
---

{{< callout >}}
  In this section we will reproduce the same chart as the [Creating Your First JavaScript Chart](https://apexcharts.com/docs/creating-first-javascript-chart/) section of the Apex Charts docs.
{{< /callout >}}

After installing [Axis](/docs/installation) and [Apex Charts](https://apexcharts.com/docs/installation/), we can instantiate a chart object and pass it to a view on a controller:

```php
use Axis\Chart;

class ExampleController extends Controller
{
    public function __invoke(): View
    {
        $chart = Chart::apex([
            'chart' => ['type' => 'line'],
            'series' => [[
                'name' => 'sales',
                'data' => [30, 40, 35, 50, 49, 60, 70, 91, 125],
            ]],
            'xaxis' => [
                'categories' => [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999],
            ],
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

You should get a chart like [this one](https://codepen.io/apexcharts/pen/xYqyYm).

Pretty simple, right?

