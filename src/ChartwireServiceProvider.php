<?php

namespace Chartwire;

use Chartwire\Livewire\Chart;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ChartwireServiceProvider extends ServiceProvider
{
    private string $packageName = 'chartwire';

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->packageName);
    }
}
