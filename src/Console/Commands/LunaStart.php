<?php

namespace DesignByCode\LunaPresets\Console\Commands;

use File;
use Illuminate\Console\Command;
use Artisan;

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

            $file = base_path('resources/assets/sass/_settings.sass');

            if (file_exists($file)) {
                if ($this->confirm('Is file already exists. Do you want to override it ?')) {
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

        $file = base_path('resources/assets/sass/_settings.sass');
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

        // if (File::exists(app_path('Http/Controllers/Auth'))){
        //     File::deleteDirectory(app_path('Http/Controllers/Auth'));
        // }

    }

    /**
     * Copy all the view files
     * @return [type] [description]
     */
    public function copyLuna()
    {

        if (!File::exists(resource_path('/views/auth'))) {
            mkdir(resource_path('/views/auth/passwords'), 0775, true);
        }

        if (!File::exists(resource_path('/views/layouts'))) {
            mkdir(resource_path('/views/layouts'), 0775, true);
        }

        copy(__DIR__.'/../../stubs/views/layouts/app.blade.php', resource_path('/views/layouts/app.blade.php'));
        copy(__DIR__.'/../../stubs/views/home.blade.php', resource_path('/views/home.blade.php'));
        copy(__DIR__.'/../../stubs/views/auth/login.blade.php', resource_path('/views/auth/login.blade.php'));
        copy(__DIR__.'/../../stubs/views/auth/register.blade.php', resource_path('/views/auth/register.blade.php'));
        copy(__DIR__.'/../../stubs/views/auth/passwords/email.blade.php', resource_path('/views/auth/passwords/email.blade.php'));
        copy(__DIR__.'/../../stubs/views/auth/passwords/reset.blade.php', resource_path('/views/auth/passwords/reset.blade.php'));
        copy(__DIR__.'/../../Http/Controllers/PagesController.php', app_path('Http/Controllers/PagesController.php'));

        $this->info('All Auth views created');


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
                $this->copyLuna();
            }
        }
    }

    /**
     * auth write routes to file
     * @return [type] [description]
     */
    public function setupAuth()
    {
        $file = fopen(base_path('/routes/web.php'), "a+");
        $string = "\nAuth::routes(); \nRoute::get('/home', 'PagesController@index')->name('home'); \n";
        fwrite($file, $string);
        fclose($file);
    }


}


