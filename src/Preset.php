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
        static::removeAppProvider();
        static::cleanSassDirectory();
        static::updatePackages();
        static::updateMix();
        static::updateScripts();
        static::updateStyles();
        static::updateWelcome();
    }


    /**
     * [cleanSassDirectory description]
     * @return [type] [description]
     */
    public static function cleanSassDirectory()
    {
        File::cleanDirectory(resource_path('sass'));
        File::cleanDirectory(public_path('css'));
    }

    /**
     * [updatePackageArray description]
     * @param  [type] $packages [description]
     * @return [type]           [description]
     */
    public static function updatePackageArray($packages)
    {
        return array_merge(
            [
                "luna-sass" => "1.x",
                "path" => "^0.12.7",
                "imagemin-webpack-plugin" => "^2.x",
                "copy-webpack-plugin" => "^4.x",
                "imagemin-mozjpeg" => "^7.x"
            ], Arr::except($packages, [
                "popper.js",
                "bootstrap",
                "lodash"
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
        copy(__DIR__.'/stubs/scripts/app.js', resource_path('js/app.js'));
        copy(__DIR__.'/stubs/scripts/bootstrap.js', resource_path('js/bootstrap.js'));
    }

    /**
     * [updateStyles description]
     * @return [type] [description]
     */
    public static function updateStyles()
    {
        copy(__DIR__.'/stubs/styles/style.sass', resource_path('sass/style.sass'));
        mkdir(resource_path('sass/project'));
        mkdir(resource_path('img'));

    }

    /**
     * Copy Welcome View
     */
    public static function updateWelcome()
    {
        copy(__DIR__.'/stubs/views/welcome.blade.php', resource_path('/views/welcome.blade.php'));
    }

    public static function removeAppProvider($path = 'Providers/AppServiceProvider.php')
    {
        $file = app_path($path);

        if (!file_exists($file)) {
            echo ("Error deleted: $file not found! \n");
        }else {
            unlink($file);
            copy(__DIR__.'/stubs/providers/AppServiceProvider.php', app_path('/Providers/AppServiceProvider.php'));
            echo ("Successfully Updated $file \n");
        }
    }


}
