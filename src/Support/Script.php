<?php

namespace Axis\Support;

use Illuminate\Support\Str;
use JsonSerializable;

final readonly class Script implements JsonSerializable
{
    private function __construct(private string $expression) {}

    public function getExpression(): string
    {
        return $this->expression;
    }

    public static function from(string $expression): static
    {
        return new self($expression);
    }

    public function replace(string $json): string
    {
        return Str::of($json)->replace("\"{$this->jsonSerialize()}\"", $this->expression);
    }

    public function jsonSerialize(): string
    {
        return md5($this->expression);
    }
}
