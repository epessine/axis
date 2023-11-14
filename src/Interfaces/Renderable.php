<?php

namespace Axis\Interfaces;

interface Renderable
{
    public function toJavascript(): string;

    public function toHtml(): string;
}
