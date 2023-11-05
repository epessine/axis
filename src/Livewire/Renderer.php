<?php

namespace Chartwire\Livewire;

use Chartwire\Charts\Bar;
use Chartwire\Charts\Base;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\Computed;

class Renderer extends Component
{
    public string $script;

    public function mount(Base $chart): void
    {
        $this->script = $this->script($chart);
    }

    protected function minify($subject): string
    {
        return str(preg_replace('~(\v|\t|\s{2,})~m', '', $subject))
            ->between('<script>', '</script>')
            ->trim();
    }

    protected function script(Base $chart): string
    {
        return $this->minify(Blade::render(
            "<x-chartwire::script :\$id :\$chart />",
            ['id' => $this->getId(), 'chart' => $chart],
        ));
    }

    public function render(): string
    {
        return <<<BLADE
        <div>
            <div wire:ignore
                x-data="{{ \$script }}">
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>
        BLADE;
    }
}
