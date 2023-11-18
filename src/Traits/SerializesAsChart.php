<?php

namespace Axis\Traits;

use Axis\AxisHelper;

trait SerializesAsChart
{
    public function serialize(): ?string
    {
        return serialize($this->config);
    }

    public function unserialize(string $data): void
    {
        $this->__construct(unserialize($data), AxisHelper::current());
    }
}
