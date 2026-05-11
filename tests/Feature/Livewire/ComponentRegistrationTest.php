<?php

use Axis\Interfaces\Renderable;
use Axis\Livewire\Renderer;
use Livewire\LivewireManager;

test('it should register the renderer component alias', function () {
    /** @var LivewireManager $livewire */
    $livewire = app('livewire');

    expect($livewire->exists(Renderer::ALIAS))->toBeTrue();
});

test('it should resolve renderer alias to renderer component class', function () {
    /** @var LivewireManager $livewire */
    $livewire = app('livewire');

    expect($livewire->new(Renderer::ALIAS))->toBeInstanceOf(Renderer::class);
});

test('it should mount renderer by shared alias constant', function () {
    /** @var LivewireManager $livewire */
    $livewire = app('livewire');

    $chart = new class implements Renderable
    {
        public function getContainerElement(): string
        {
            return 'canvas';
        }

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

    $livewire->test(Renderer::ALIAS, [$chart])
        ->assertSeeHtml('axis-id="chart"')
        ->assertSeeHtml('wire:ignore')
        ->assertSeeHtml('x-ref="container"');
});
