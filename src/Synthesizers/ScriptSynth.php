<?php

namespace Axis\Synthesizers;

use Axis\Support\Script;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

final class ScriptSynth extends Synth
{
    public static string $key = 'axis-script';

    public static function match(mixed $target): bool
    {
        return $target instanceof Script;
    }

    /**
     * @return string[][]
     */
    public function dehydrate(Script $target): array
    {
        return [['expression' => $target->getExpression()], []];
    }

    /**
     * @param  string[]  $value
     */
    public function hydrate(array $value): Script
    {
        return Script::from($value['expression']);
    }
}
