<?php

namespace Axis\Traits;

use Axis\Support\Script;
use Illuminate\Support\Stringable;

trait ParsesJs
{
    /**
     * @param  iterable<(int|string), mixed>  $data
     */
    protected function js(iterable $data): string
    {
        $encoded = json_encode($data, JSON_THROW_ON_ERROR);

        /** @var array<Script> */
        $scripts = collect($data)
            ->dot()
            ->filter(fn (mixed $item): bool => $item instanceof Script)
            ->all();

        foreach ($scripts as $script) {
            $encoded = $script->replace($encoded);
        }

        return $encoded;
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
