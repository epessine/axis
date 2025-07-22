---
title: 'Advanced Usage guide'
weight: 5
prev: /docs/interacting-with-charts
---

# Adding Filtering to Axis Charts

Axis does not currently provide built-in UI controls for date, range, or data filtering in charts. Instead, you can implement powerful filtering capabilities yourself by leveraging Livewire or Blade components and Axis's flexible chart update logic.

## How to Add Filtering to Your Charts

1. **Create your filter inputs in Livewire or Blade:**
   - Use date pickers, dropdowns, text fields, or any other UI components in your Livewire or Blade templates.
   - Example: Place a `<input type="date">` or `<select>` above your chart to let users select filter criteria.

2. **Capture the user’s selected filter criteria:**
   - In Livewire, store selections like date ranges or categories in Livewire properties.
   - In Blade, pass the filter values as component data or form submissions.

3. **Update the chart data/options in response to filter changes:**
   - When a filter is changed, recompute the dataset and options that you pass to the chart instance.
   - Example: Use database queries or collections in your Livewire component to fetch filtered data, then pass it to the chart builder (`->series(...)`, `->labels(...)`, `->options(...)`).

4. **Refresh the chart by calling its `update()` method:**
   - After updating the chart’s data/config, call the chart's `update()` method so the rendered chart reflects your latest filter choices.
   - For example, in a Livewire component:

     ```php
     $this->chart->series('Revenue', $filteredData);
     $this->chart->update();
     ```

   - See `AsAxisChart.php` for the underlying implementation.

## Example Livewire Usage

```php
use Axis\Charts\Apex;
use Axis\Enums\Type;
use Axis\Support\Script;
use Axis\Chart;
use Axis\Attributes\Axis;

class Report extends \Livewire\Component
{
    public $dateFrom;
    public $dateTo;
    public $chart;

    public function mount()
    {
        $this->dateFrom = now()->subMonth()->toDateString();
        $this->dateTo = now()->toDateString();
    }

    #[Axis]
    public function chart(): Apex
    {
        $filtered = Revenue::query()
            ->whereBetween('date', [$this->dateFrom, $this->dateTo])
            ->pluck('amount', 'date');

        return Chart::apex()
            ->type(Type::Area)
            ->labels($filtered->keys())
            ->series('Revenue', $filtered->values());
    }

    public function updated($property)
    {
        if (in_array($property, ['dateFrom', 'dateTo'])) {
            $this->updateChart();
        }
    }

    public function updateChart()
    {
        $this->chart->update();
    }
}
```

This pattern works similarly with Blade or other frameworks—filter user inputs, update the chart's dataset, and call `$this->chart->update()`.