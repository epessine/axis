---
title: 'Using with Livewire'
weight: 4
prev: /docs/interacting-with-charts
---

### The `Axis` attribute

When using Axis to draw charts on Livewire components, you should use the `Axis` attribute on a component method and return a chart object instance:

```php
use Axis\Attributes\Axis;
use Axis\Charts\ChartJs;
use Axis\Chart;

class Example extends Component
{
    #[Axis]
    public function chart(): ChartJs
    {
        return Chart::chartjs()
            ->radar()
            ->title('Livewire Chart')
            ->labels(['Mon', 'Tue', 'Wed', 'Thu'])
            ->series('Clicks', [4, 12, 43, 27]);
    }
}
```

Then you can use it just as a computed property on the component view:

```html
<div>
    <h1>Livewire Chart Example:</h1>
    <div>
        {{ $this->chart }}
    </div>
</div>
```

But why not just instantiate the chart on the component `render()` hook and pass it to the view?

By using the `Axis` attribute, you get several advantages:
- You can control when the chart will be updated
- The chart update will happen *via Javascript*, meaning that the chart JS instance is preserved between updates, keeping the chart state and references.
- You get easy access to the chart JS instance with the `$chart` magic ([see below](#interactions)).

### Updating the chart

If you're using component properties to compose the chart config, you need to manually update the chart to reflect the changes:

```php
use Axis\Attributes\Axis;
use Axis\Charts\ChartJs;
use Axis\Chart;

class Example extends Component
{
    public array $labels = ['A', 'B', 'C'];

    #[Axis]
    public function chart(): ChartJs
    {
        return Chart::chartjs()
            ->pie()
            ->title('Livewire Chart')
            ->labels($this->labels)
            ->series('Quantity', [65, 42, 31]);
    }

    public function changeLabels(): void
    {
        $this->labels = ['X', 'Y', 'Z'];

        $this->chart->update(); // use the update() method to reflect changes
    }
}
```

If you want the chart to always be auto-updated, you can call the chart object `update()` method on the component's `render()` hook.

### Interactions

If you want to run some Javascript code on the Livewire component to interact with the chart, you can use the chart object `run()` method. This way you can use the `$chart` magic to access the chart JS instance:

```php
use Axis\Attributes\Axis;
use Axis\Charts\ChartJs;
use Axis\Chart;

class Example extends Component
{
    #[Axis]
    public function chart(): ChartJs
    {
        return Chart::chartjs()
            ->column()
            ->title('Livewire Chart')
            ->labels(['Mon', 'Tue', 'Wed', 'Thu'])
            ->series('Clicks', [22, 31, 9, 58]);
    }

    public function destroyChart(): void
    {
        $this->chart->run(<<<'JS'
            $chart.destroy(); // the $chart magic refers to the chart JS instance
            console.log('chart destroyed!');
        JS);
    }
}
```