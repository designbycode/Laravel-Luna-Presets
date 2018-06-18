<?php

namespace DesignByCode\LunaPresets;

use DesignByCode\LunaPresets\Preset;
use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\ServiceProvider;


class LunaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('luna', function ($command) {
            Preset::install();

            $command->info('Thanks for using Luna-sass');
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
