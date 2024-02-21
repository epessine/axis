<?php

namespace Axis\Traits;

use Axis\Enums\Type;

trait IsFluent
{
    abstract public function title(string $title): static;

    abstract public function labels(iterable $labels): static;

    abstract public function type(Type $type): static;

    abstract public function options(iterable $options, bool $overwrite = false): static;

    abstract public function series(iterable $data, Type $type = null, iterable $options = []): static;
}
