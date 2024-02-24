---
title: 'Highcharts'
weight: 3
prev: /docs/drawing-charts
next: false
---

{{< callout >}}
  In this section we will reproduce the same chart as the [Your First Chart](https://www.highcharts.com/docs/getting-started/your-first-chart) section of the Highcharts docs.
{{< /callout >}}

After installing [Axis](/docs/installation) and [Highcharts](https://www.highcharts.com/docs/getting-started/installation), we can instantiate a chart object and pass it to a view on a controller:

```php
use Axis\Chart;

class ExampleController extends Controller
{
    public function __invoke(): View
    {
        $chart = Chart::highcharts()
            ->bar()
            ->title('Fruit Consumption')
            ->labels(['Apples', 'Bananas', 'Oranges'])
            ->series('Jane', [1, 0, 4])
            ->series('John', [5, 7, 3])
            ->options(['yAxis' => ['title' => ['text' => 'Fruit eaten']]]);

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

![](https://www.highcharts.com/docs/assets/images/bar-fruit-consumption-832124cda98ce6e3ea6f58a86825447c.png?)

Pretty simple, right?
