<?php

namespace App\Console\Commands;

use App\Actions\Command\SitemapGenerateAction;
use Illuminate\Console\Command;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sitemap generate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        SitemapGenerateAction::run();
    }
}
