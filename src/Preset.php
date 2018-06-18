<?php

namespace DesignByCode\LunaPresets;

use Illuminate\Foundation\Console\Presets\Preset as LunaPreset;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class Preset extends LunaPreset
{
    /**
     * [install description]
     * @return [type] [description]
     */
    public static function install()
    {
        static::cleanSassDirectory();
        static::updatePackages();
        static::updateMix();
        static::updateScripts();
        static::updateStyles();
        static::updateViews();
    }


    /**
     * [cleanSassDirectory description]
     * @return [type] [description]
     */
    public static function cleanSassDirectory()
    {
        File::cleanDirectory(resource_path('assets/sass'));
        File::cleanDirectory(public_path('css'));
    }

    /**
     * [updatePackageArray description]
     * @param  [type] $packages [description]
     * @return [type]           [description]
     */
    public static function updatePackageArray($packages)
    {
        return array_merge(["luna-sass" => "^1.0.0"], Arr::except($packages, [
            "popper.js",
            "bootstrap",
            "lodash",
        ]));
    }


    /**
     * [updateMix description]
     * @return [type] [description]
     */
    public static function updateMix()
    {
        copy(__DIR__.'/stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * [updateScripts description]
     * @return [type] [description]
     */
    public static function updateScripts()
    {
        copy(__DIR__.'/stubs/scripts/app.js', resource_path('assets/js/app.js'));
        copy(__DIR__.'/stubs/scripts/bootstrap.js', resource_path('assets/js/bootstrap.js'));
    }

    /**
     * [updateStyles description]
     * @return [type] [description]
     */
    public static function updateStyles()
    {
        copy(__DIR__.'/stubs/styles/style.sass', resource_path('assets/sass/style.sass'));
        mkdir(resource_path('assets/sass/project'));
        if (file_exists(base_path('node_modules/luna-sass/Framework/sass/_settings.sass'))) {
            copy(
                base_path('node_modules/luna-sass/Framework/sass/_settings.sass'),
                resource_path('assets/sass/_settings.sass'));
        }else {
            File::put(resource_path('assets/sass/_settings.sass'), '//Copy _settings.sass content in here from luna-sass in node_modules');
        }
    }


    /**
     * [updateViews description]
     * @return [type] [description]
     */
    public static function updateViews()
    {
        copy(__DIR__.'/stubs/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }



}
