<?php

namespace Axis\Traits;

use Axis\Livewire\Renderer;

trait RendersAsChart
{
    public function toHtml(): string
    {
        return app('livewire')->mount(Renderer::class, ['chart' => $this], $this->id);
    }
}
