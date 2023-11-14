<?php

namespace Axis\Livewire;

use Axis\Interfaces\Renderable;
use Livewire\Component;

final class Renderer extends Component
{
    public function mount(Renderable $chart): void
    {
        $this->js(<<<JS
        window.\$axis ??= {};
        window.\$axis['{$this->getId()}'] = {$chart->toJavascript()};
        JS);
    }

    public function clearScript(): void
    {
        $this->js(<<<JS
        delete window.\$axis['{$this->getId()}'];
        JS);
    }

    public function render(): string
    {
        return <<<BLADE
            <div>
                <div wire:ignore
                    x-data="\$axis['{$this->getId()}']">
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>
        BLADE;
    }
}
