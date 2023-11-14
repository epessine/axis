<?php

namespace Chartwire\Livewire;

use Chartwire\Interfaces\Renderable;
use Livewire\Component;

final class Renderer extends Component
{
    public function mount(Renderable $chart): void
    {
        $this->js(<<<JS
        window.\$chartwire ??= {};
        window.\$chartwire['{$this->getId()}'] = {$chart->toJavascript()};
        JS);
    }

    public function clearScript(): void
    {
        $this->js(<<<JS
        delete window.\$chartwire['{$this->getId()}'];
        JS);
    }

    public function render(): string
    {
        return <<<BLADE
            <div>
                <div wire:ignore
                    x-data="\$chartwire['{$this->getId()}']">
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>
        BLADE;
    }
}
