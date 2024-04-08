<?php

namespace App\Console\Commands;

use App\Exports\MarkerExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

    }
}
