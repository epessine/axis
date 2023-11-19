<?php

namespace Axis\Livewire;

use Axis\Interfaces\Renderable;
use Livewire\Component;

final class Renderer extends Component
{
    public string $chartId;

    public string $containerElement = 'div';

    public function mount(Renderable $chart): void
    {
        $this->chartId = $chart->getId();
        $this->containerElement = $chart->getContainerElement();

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
                <div wire:ignore x-data="\$axis['{$this->getId()}']"
                    axis-id="{$this->chartId}">
                    <{$this->containerElement} wire:ignore
                        x-ref="container"
                        wire:key="{$this->chartId}-container"
                    ></{$this->containerElement}>
                </div>
            </div>
        BLADE;
    }
}
