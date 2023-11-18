<?php

function invade(object $target, string $prop): mixed
{
    return \Closure::fromCallable(fn () => $this->$prop)->call($target);
}
