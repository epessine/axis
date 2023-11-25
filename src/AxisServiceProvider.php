<?php

namespace Axis;

use Axis\Livewire\Renderer;
use Axis\Synthesizers\ScriptSynth;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

final class AxisServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('axis::renderer', Renderer::class);
        Livewire::propertySynthesizer(ScriptSynth::class); // @phpstan-ignore-line
    }
}
