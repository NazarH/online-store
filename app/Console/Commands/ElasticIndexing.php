<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ElasticIndexing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:indexing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexing DB items';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->productsIndexing();
    }

    private function productsIndexing()
    {
        Product::chunk(100, function ($products) {
            foreach ($products as $product) {
                $product->index();
            }
        });

        $this->info('Products data indexed successfully.');
    }
}
