<?php

namespace Axis\Traits;

use Axis\Attributes\Axis;
use Livewire\Component;

trait AsAxisChart
{
    use ParsesJs, RendersAsChart, SerializesAsChart;

    protected readonly string $id;

    protected readonly ?Component $component;

    /**
     * @param  array<string, mixed>  $config
     */
    public function __construct(
        protected array $config,
        protected readonly ?Axis $attribute = null,
    ) {
        $this->id = $this->attribute?->getChartId() ?? uniqid('axis_');
        $this->component = $this->attribute?->getComponent();
    }

    abstract protected function bootScript(): string;

    abstract protected function updateScript(): string;

    public function getId(): string
    {
        return $this->id;
    }

    public function run(string $expression): void
    {
        $this->component->js($this->minify($expression));
    }

    protected function syncState(): void
    {
        unset($this->component->{$this->attribute->getName()});

        $this->config = $this->component->{$this->attribute->getName()}->config;
    }

    public function toJavascript(): string
    {
        return $this->minify(<<<JS
            {
                init() {
                    window.\$chart = {$this->bootScript()};
                    this.\$wire.clearScript();
                }
            }
        JS);
    }

    public function update(): void
    {
        $this->syncState();

        $this->component->js($this->minify(<<<JS
            if (window.\$axis) {
                {$this->updateScript()}
            }
        JS));
    }
}
