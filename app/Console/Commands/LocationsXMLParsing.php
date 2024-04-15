<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Orchestra\Parser\Xml\Facade as XmlParser;

class LocationsXMLParsing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing XML file & create records in locations table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $xml = XmlParser::load('public/xml/locations.xml');

        $progressbar = $this->output->createProgressBar(count($xml->getContent()->RECORD));
        $progressbar->start();

        foreach ($xml->getContent()->RECORD as $record) {
            if (strval($record->CITY_NAME)) {
                Location::firstOrCreate([
                    'obl_name' => strval($record->OBL_NAME),
                    'region_name' => strval($record->REGION_NAME),
                    'city_name' => strval($record->CITY_NAME),
                ]);

                $progressbar->advance();
            }
        }

        $progressbar->finish();

        return 0;
    }
}
