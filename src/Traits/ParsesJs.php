<?php

namespace Axis\Traits;

use Illuminate\Support\Js;
use Illuminate\Support\Stringable;

trait ParsesJs
{
    protected function js(mixed $data): string
    {
        return Js::from($data)->toHtml();
    }

    protected function minify(string $expression): string
    {
        return str(preg_replace('~(\v|\t|\s{2,})~m', '', $expression))
            ->when(
                property_exists($this, 'id'),
                fn (Stringable $str): Stringable => $str->replace('$chart', "\$axis['{$this->id}']"),
            )
            ->replace('$container', 'this.$refs.container')
            ->trim();
    }
}
