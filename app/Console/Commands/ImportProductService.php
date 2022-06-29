<?php

namespace App\Console\Commands;

use App\Http\Services\ImportProductByAPIService;
use Illuminate\Console\Command;

class ImportProductService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {id=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = str_replace("id=","",$this->argument('id'));
        $service = new ImportProductByAPIService($id);
        $service->process();
    }
}
