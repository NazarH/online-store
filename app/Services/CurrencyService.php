<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * Отримує дані про валюту з кешу або відправляє запит до API та зберігає їх у кеші на певний час.
     *
     * @return array
     */
    public function show(): array
    {
        return Cache::remember('currencies', 3600, function(){
            return $this->filter($this->doRequest());
        });
    }

    /**
     * Виконує запит до API ПриватБанку та отримує дані про валюту на поточну дату.
     *
     * @return array
     */
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

    /**
     * Фільтрує масив даних про валюту, залишаючи тільки валюти, які налаштовані як допоміжні.
     *
     * @param  array  $data
     * @return array
     */
    private function filter(array $data): array
    {
        return Arr::where($data, function($value){
            return in_array($value['currency'], config('currency')['secondaryCurrencies']);
        });
    }
}
