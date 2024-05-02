<?php

function invade(object $target, string $prop): mixed
{
    return \Closure::fromCallable(fn () => $this->$prop)->call($target);
}

function invadeCall(object $target, string $method, mixed ...$args): mixed
{
    return \Closure::fromCallable(fn () => $this->$method(...$args))->call($target);
}

function minify(string $expression): string
{
    return preg_replace('~(\v|\t|\s{2,})~m', '', $expression);
}
