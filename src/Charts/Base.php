<?php

namespace Chartwire\Charts;

use Chartwire\Datasets\Base as BaseDataset;
use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\Support\Htmlable;

class Base implements Htmlable
{
    const TYPE = null;

    protected array $labels = [];

    protected array $datasets = [];

    public function labels(string ...$labels)
    {
        $this->labels = $labels;

        return $this;
    }

    public function datasets(BaseDataset ...$datasets)
    {
        $this->datasets = $datasets;

        return $this;
    }

    public function toHtml(): string
    {
        $id = json_encode(get_object_vars($this));

        return Blade::render(
            <<<BLADE
            @livewire(Chartwire\Livewire\Renderer::class, [
                'chart' => \$chart,
                'key' => '$id',
            ])
            BLADE,
            ['chart' => $this],
        );
    }
}
