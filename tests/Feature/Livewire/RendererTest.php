<?php

use Axis\Interfaces\Renderable;
use Axis\Livewire\Renderer;
use Livewire\Features\SupportTesting\Testable;

use function Pest\Livewire\livewire;

test('it should render properly', function () {
    $chart = new class implements Renderable
    {
        public function getId(): string
        {
            return 'chart';
        }

        public function toJavascript(): string
        {
            return 'chart';
        }

        public function toHtml(): string
        {
            return '<div></div>';
        }
    };

    livewire(Renderer::class, [$chart])
        ->assertSeeHtml('axis-id="chart"')
        ->assertSeeHtml('wire:ignore')
        ->assertSeeHtml('x-ref="container"')
        ->tap(fn (Testable $testable) => $testable->assertSeeHtml("x-data=\"\$axis['{$testable->id()}']\""));
});
