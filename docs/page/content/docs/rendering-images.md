---
title: "Rendering Images"
weight: 5
prev: /docs/using-with-livewire
---

You can also use Axis to render charts directly on the server as images - to use them on emails, notifications or exporting to external services. It uses the same syntax as client-side rendered charts, so all your charts are interactive and exportable!

### Requirements

Axis uses [Node](https://nodejs.org/en) and [Puppeteer](https://pptr.dev/guides/installation) under the hood, so both need to be installed and accessible to the system's webserver user.

### Usage

After creating your chart, you can call `toPng()`, `toWebp()` or `toJpeg()` to generate an screenshot of the chart and get it's contents. After that, you can save it on storage, for instance:

```php
class ExampleController extends Controller
{
    public function __invoke(): View
    {
        $chart = Chart::chartjs()
            ->column()
            ->labels(['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'])
            ->series('# of Votes', [12, 19, 3, 5, 2, 3], ['borderWidth' => 1])
            ->options(['scales' => [
                'y' => ['beginAtZero' => true],
            ]]);

        Storage::put('chartjs.png', $chart->toPng());
    }
}
```

You can also set the Node binary path if needed:

```php
$image = $chart->setNodeBinary('/usr/local/bin/node')->toPng();

Storage::put('chartjs.png', $image);
```

It is _that_ easy!