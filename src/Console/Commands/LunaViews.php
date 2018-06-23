<?php

namespace DesignByCode\LunaPresets\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LunaViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'luna:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Override the default bootstrap style with Luna-sass views';

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
        File::cleanDirectory(resource_path('/views/layouts'));

        $this->copyLuna();

    }


    public function copyLuna()
    {

        copy(__DIR__.'/../../stubs/views/layouts/app.blade.php', resource_path('/views/layouts/app.blade.php'));


    }

}
