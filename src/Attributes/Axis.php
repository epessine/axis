<?php

namespace Axis\Attributes;

use Livewire\Attributes\Computed;

#[\Attribute]
final class Axis extends Computed
{
    public function __construct()
    {
        parent::__construct(true);
    }

    public function getChartId(): string
    {
        return $this->getComponent()->getId().'::'.$this->getName();
    }
}
