<?php

namespace Chartwire\Attributes;

use Livewire\Attributes\Computed;

#[\Attribute]
final class Chartwire extends Computed
{
    public function getChartId(): string
    {
        return $this->getComponent()->getId().'::'.$this->getName();
    }
}
