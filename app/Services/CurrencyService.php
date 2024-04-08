<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    public function show(): array
    {
        return Cache::remember('currencies', 3600, function(){
            return $this->filter($this->doRequest());
        });
    }

    protected function doRequest(): array
    {
        try {
            return Http::get('https://api.privatbank.ua/p24api/exchange_rates?date=' . date("d.m.Y"))
                ->json()['exchangeRate'];
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }

        return [];
    }

    private function filter(array $data): array
    {
        return Arr::where($data, function($value){
            return in_array($value['currency'], config('currency')['secondaryCurrencies']);
        });
    }
}
