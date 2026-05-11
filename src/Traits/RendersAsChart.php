<?php

namespace Axis\Traits;

use Livewire\LivewireManager;

trait RendersAsChart
{
    public function toHtml(): string
    {
        /** @var LivewireManager $livewire */
        $livewire = app('livewire');

        return $livewire->mount('axis-renderer', ['chart' => $this], $this->id);
    }
}
