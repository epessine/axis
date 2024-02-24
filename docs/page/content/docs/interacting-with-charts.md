---
title: "Interacting with Charts"
weight: 3
prev: /docs/your-first-chart
---

### The global `$axis` object

Every chart rendered by Axis is stored on the global Javascript object `$axis` or `window.$axis`. You can access the chart instance via `$axis['chart-id']`, and the `chart-id` can be obtained using the Axis chart object `getId()` method:

```php
use Axis\Chart;

$chart = Chart::chartjs()
    ->line()
    ->title('Example')
    ->labels(['Mon', 'Tue', 'Wed', 'Thu'])
    ->series('Interactions', [1, 3, 4, 6]);

$chartId = $chart->getId(); // $chartId stores the chart instance id
```

You can use this identifier to interact with the chart instance via Javascript:

```html
<section>
    <h1>Chart Interaction Example</h1>
    <div>{{ $chart }}</div>
    <button type="button" onclick="$axis[@js($chartId)].destroy()">
        DON'T PRESS
    </button>
</section>
```

In the above example, when the button is clicked, the chart instance will be destroyed.
