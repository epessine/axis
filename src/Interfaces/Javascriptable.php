<?php

namespace Chartwire\Interfaces;

interface Javascriptable
{
    public function update(): void;

    public function run(string $expression): void;
}
