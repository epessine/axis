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
        /** @var array<string, mixed> $config */
        $config = unserialize($data);

        $this->__construct($config, AxisHelper::current());
    }
}
