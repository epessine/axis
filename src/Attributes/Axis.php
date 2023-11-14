<?php

namespace Axis\Attributes;

use Livewire\Attributes\Computed;

#[\Attribute]
final class Axis extends Computed
{
    public function getChartId(): string
    {
        return $this->getComponent()->getId().'::'.$this->getName();
    }
}
