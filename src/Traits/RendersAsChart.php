<?php

namespace Axis\Traits;

use Axis\Livewire\Renderer;
use Livewire\LivewireManager;

trait RendersAsChart
{
    public function toHtml(): string
    {
        /** @var LivewireManager $livewire */
        $livewire = app('livewire');

        return $livewire->mount(Renderer::ALIAS, ['chart' => $this], $this->id);
    }
}
