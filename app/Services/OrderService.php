<?php

namespace App\Services;

use Cloudipsp\Checkout;
use Cloudipsp\Configuration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class OrderService
{
    /**
     * Викликає платіжний шлюз для онлайн-оплати замовлення.
     *
     * @param array $data
     * @param string $key
     */
    public function onlinePayment(array $data, string $key)
    {
        Configuration::setMerchantId(config('services.payment.merchantId'));
        Configuration::setSecretKey(config('services.payment.merchantKey'));

        $info = [
            'currency' => 'UAH',
            'amount' => $data['price'] * 100,
            'response_url' => route('client.order.response'),
            'server_callback_url' => env('NGROK_URL').'/webhook/order/callback',
            'merchant_data' => array(
                'order_key' => $key,
            )
        ];

        return Checkout::url($info);
    }
}
