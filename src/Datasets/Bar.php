<?php

namespace Chartwire\Datasets;

use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\Support\Htmlable;

class Bar extends Base
{
    public function data(int|float ...$values)
    {
        $this->data = $values;

        return $this;
    }
}
