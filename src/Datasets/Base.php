<?php

namespace Chartwire\Datasets;

use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\Support\Htmlable;

class Base
{
    protected string $label;

    protected array $data;

    public function __call($name, $arguments)
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $arguments;

            return $this;
        }
    }

    public function label(string $value)
    {
        $this->label = $value;

        return $this;
    }
}
