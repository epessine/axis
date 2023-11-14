<?php

namespace Axis\Traits;

use Illuminate\Support\Js;

trait RendersScript
{
    protected function js(mixed $data): string
    {
        return Js::from($data)->toHtml();
    }

    protected function minify(string $subject): string
    {
        return str(preg_replace('~(\v|\t|\s{2,})~m', '', $subject))->trim();
    }
}
