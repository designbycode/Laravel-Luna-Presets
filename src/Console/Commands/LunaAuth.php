<?php

namespace DesignByCode\LunaPresets\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class LunaAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Override the default bootstrap style with Luna-sass styles';

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
    }

    public function overrideAuth()
    {
        File::cleanDirectory(resource_path('/views/auth'));
        $this->info('Cleaning Auth Directory');
        File::cleanDirectory(resource_path('/views/layouts'));
        $this->info('Cleaning Layouts Directory');

        $this->copyLuna();

    }


    public function copyLuna()
    {

        copy(__DIR__.'/../../stubs/views/layouts/app.blade.php', resource_path('/views/layouts/app.blade.php'));
        copy(__DIR__.'/../../stubs/views/auth/login.blade.php', resource_path('/views/auth/login.blade.php'));
        copy(__DIR__.'/../../stubs/views/auth/register.blade.php', resource_path('/views/auth/register.blade.php'));
        mkdir(resource_path('/views/auth/passwords'));
        copy(__DIR__.'/../../stubs/views/auth/passwords/email.blade.php', resource_path('/views/auth/passwords/email.blade.php'));
        copy(__DIR__.'/../../stubs/views/auth/passwords/reset.blade.php', resource_path('/views/auth/passwords/reset.blade.php'));
        $this->info('All views created');

    }



}
