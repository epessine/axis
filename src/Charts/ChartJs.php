<?php

namespace Axis\Charts;

use Axis\Attributes\Axis;
use Axis\Interfaces\Javascriptable;
use Axis\Interfaces\Renderable;
use Axis\Livewire\Renderer;
use Axis\Traits\RendersScript;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Component;

final class ChartJs implements Htmlable, Javascriptable, Renderable
{
    use RendersScript;

    private readonly string $id;

    private readonly ?Component $component;

    /**
     * @param  array<string, mixed>  $config
     */
    public function __construct(
        protected array $config,
        public ?Axis $attribute,
    ) {
        $this->id = $this->attribute?->getChartId() ?? uniqid();
        $this->component = $this->attribute->getComponent();
    }

    public function toJavascript(): string
    {
        return $this->minify(<<<JS
            {
                init() {
                    window.\$axis[{$this->js($this->id)}] = new Chart(
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
            if (window.\$axis) {
                \$axis['{$this->id}'].data = {$this->js($this->config)}.data;
                \$axis['{$this->id}'].update();
            }
        JS);
    }

    public function run(string $expression): void
    {
        $this->component->js(str($expression)
            ->replace('$chart', "\$axis['{$this->id}']")
            ->toString());
    }

    public function toHtml(): string
    {
        return app('livewire')->mount(Renderer::class, ['chart' => $this], $this->id); // @phpstan-ignore-line
    }
}
