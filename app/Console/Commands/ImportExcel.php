<?php

namespace App\Console\Commands;

use App\Imports\ProductImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from excel';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        ini_set('memory_limit', '-1');

        Excel::import(new ProductImport(), 'export-market.xlsx');
    }
}
