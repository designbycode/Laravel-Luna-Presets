<?php

namespace DesignByCode\LunaPresets\Console\Commands;

use File;
use Illuminate\Console\Command;
use Artisan;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;


class LunaStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup all the view required for luna sass';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->overrideAuth();
        $this->copySettings();
        $this->settingsVars();
        $this->makeAuth();
    }

    /**
     * Copy settings file from luna-sass
     * @return [type] [description]
     */
    public function copySettings()
    {
        if (file_exists(base_path('node_modules/luna-sass/Framework/sass/_settings.sass'))) {

            $file = base_path('resources/sass/_settings.sass');

            if (file_exists($file)) {
                if ($this->choice('_settings file already exists. Do you want to override it ?', ['yes', 'no'], 0)) {
                    copy(base_path('node_modules/luna-sass/Framework/sass/_settings.sass'), $file);
                }
            }else{
                copy(base_path('node_modules/luna-sass/Framework/sass/_settings.sass'), $file);
            }

        }else {
           $this->info('node_module for luna-sass not found.');
           $this->info('npm install luna-sass or yarn add luna-sass');
        }

    }

    /**
     * Change this file path for lunacon icons
     * @return [type] [description]
     */
    public function settingsVars()
    {
        $file = base_path('resources/sass/_settings.sass');

        if (file_exists($file)) {
            $contents = file_get_contents($file);
            $fn = fopen($file, "w");
            $var1 = "vendor/icons";
            $var2 = "~luna-sass/Framework/sass/vendor/icons";
            $contents = str_replace($var1, $var2 ,$contents);
            fwrite($fn, $contents);
            fclose($fn);
        }
    }

    /**
     * Remove laravel auth files
     * @return [type] [description]
     */
    public function overrideAuth()
    {
        if (File::exists(resource_path('/views/auth'))){
            File::deleteDirectory(resource_path('/views/auth'));
        }

        if (File::exists(resource_path('/views/layouts'))){
            File::deleteDirectory(resource_path('/views/layouts'));
        }

        if (File::exists(resource_path('/views/home.blade.php'))) {
            unlink(resource_path('/views/home.blade.php'));
        }

        if (File::exists(app_path('Http/Controllers/HomeController.php'))) {
            unlink(app_path('Http/Controllers/HomeController.php'));
        }

    }

    /**
     * Copy all the view files
     * @return [type] [description]
     */
    public function copyLuna()
    {
        if (File::exists(resource_path('/views/partials'))){
            File::deleteDirectory(resource_path('/views/partials'));
        }

        if (File::exists(resource_path('/views/layouts'))){
            File::deleteDirectory(resource_path('/views/layouts'));
        }

        if (!File::exists(resource_path('/views/auth'))) {
            mkdir(resource_path('/views/auth/passwords'), 0775, true);
        }

        if (!File::exists(resource_path('/views/layouts'))) {
            mkdir(resource_path('/views/layouts'), 0775, true);
        }

        if (!File::exists(resource_path('/views/partials'))) {
            mkdir(resource_path('/views/partials'), 0775, true);
        }

        copy(__DIR__.'/../../stubs/styles/style.sass', resource_path('/sass/style.sass'));

        $this->recursive_copy(__DIR__.'/../../stubs/views/', resource_path('/views'));

        $this->recursive_copy(__DIR__ .'/../../stubs/styles', resource_path('sass'));

        copy(__DIR__.'/../../Http/Controllers/PagesController.php', app_path('Http/Controllers/PagesController.php'));

        $this->info('All Auth views created');

        $this->info('Thanks for using Luna-sass');
    }

    /**
     * make auth
     * @return [type] [description]
     */
    public function makeAuth()
    {
        if ($ans = $this->choice('Do you want to setup auth routes ? ', ['yes', 'no'], 0)) {
            if ( $ans === "yes") {
                $this->setupAuth();
                $this->info('Auth routes setup');
            }
        }
        $this->copyLuna();
    }

    /**
     * auth write routes to file
     * @return [type] [description]
     */
    public function setupAuth()
    {
        $file = fopen(base_path('/routes/web.php'), "a+");
        $string = "\nAuth::routes(['verify' => true]); \nRoute::get('/home', 'PagesController@index')->name('home'); \n";
        fwrite($file, $string);
        fclose($file);
    }

    public function recursive_copy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recursive_copy($src .'/'. $file, $dst .'/'. $file);
                }
                else {
                    copy($src .'/'. $file,$dst .'/'. $file);
                }
            }
        }
        closedir($dir);
    }


}


