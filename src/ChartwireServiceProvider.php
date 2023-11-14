<?php

namespace Chartwire;

use Chartwire\Livewire\Renderer;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

final class ChartwireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('chartwire::renderer', Renderer::class);
    }
}
