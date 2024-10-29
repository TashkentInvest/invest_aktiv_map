<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearOptimizeCache extends Command
{
    protected $signature = 'cache:clear-optimize';

    protected $description = 'Clear the optimized cache';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $this->info('Clearing optimized cache...');
        Artisan::call('optimize:clear');
        $this->info('Optimized cache cleared successfully.');
    }
}
