<?php

namespace Axis\Interfaces;

interface Renderable
{
    public function getId(): string;

    public function getContainerElement(): string;

    public function toJavascript(): string;

    public function toHtml(): string;
}
