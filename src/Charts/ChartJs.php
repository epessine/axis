<?php

namespace Chartwire\Charts;

use Chartwire\Attributes\Chartwire;
use Chartwire\Interfaces\Javascriptable;
use Chartwire\Interfaces\Renderable;
use Chartwire\Livewire\Renderer;
use Chartwire\Traits\RendersScript;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Component;

final class ChartJs implements Htmlable, Javascriptable, Renderable
{
    use RendersScript;

    private readonly string $id;

    private readonly ?Component $component;

    public function __construct(
        protected array $config,
        public ?Chartwire $attribute,
    ) {
        $this->id = $this->attribute?->getChartId() ?? uniqid();
        $this->component = $this->attribute->getComponent();
    }

    public function toJavascript(): string
    {
        return $this->minify(<<<JS
            {
                init() {
                    window.\$chartwire[{$this->js($this->id)}] = new Chart(
                        this.\$refs.canvas,
                        {$this->js($this->config)}
                    );
                    this.\$wire.clearScript();
                }
            }
        JS);
    }

    public function update(): void
    {
        $this->component->js(<<<JS
            if (window.\$chartwire) {
                \$chartwire['{$this->id}'].data = {$this->js($this->config)}.data;
                \$chartwire['{$this->id}'].update();
            }
        JS);
    }

    public function run(string $expression): void
    {
        $this->component->js(str($expression)
            ->replace('$chart', "\$chartwire['{$this->id}']")
            ->toString());
    }

    public function toHtml(): string
    {
        return app('livewire')->mount(Renderer::class, ['chart' => $this], $this->id);
    }
}
