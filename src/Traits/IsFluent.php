<?php

namespace Axis\Traits;

use Axis\Enums\Type;

trait IsFluent
{
    abstract public function title(string $title): static;

    abstract public function labels(iterable $labels): static;

    abstract public function type(Type $type): static;

    abstract public function options(iterable $options, bool $overwrite = false): static;

    abstract public function series(string $name, iterable $data, iterable $options = []): static;

    public function bar(): static
    {
        return $this->type(Type::Bar);
    }

    public function pie(): static
    {
        return $this->type(Type::Pie);
    }

    public function radar(): static
    {
        return $this->type(Type::Radar);
    }

    public function line(): static
    {
        return $this->type(Type::Line);
    }

    public function column(): static
    {
        return $this->type(Type::Column);
    }
}
