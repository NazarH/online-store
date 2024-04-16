<?php

namespace App\Http\User\Controllers;

use App\Actions\User\Order\OrderStoreAction;
use App\Facades\Basket;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Models\Order;
use Cloudipsp\Checkout;
use Cloudipsp\Configuration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Перевіряє наявність замовлення за ключем. Якщо замовлення відсутнє, перенаправляє на головну сторінку.
     * В іншому випадку відображає сторінку з деталями замовлення.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse
    {
        $order = Order::where('key', '=', $request->key)->with('products')->first();

        if (empty($order->products[0])) {
            return redirect()->route('client.index');
        }

        return view('client.orders.index', ['order' => $order]);
    }

    /**
     * Оновлює статус замовлення та викликає метод оплати онлайн.
     *
     * @param OrderRequest $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(OrderRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = 'expected';
        $data['role'] = 'client';
        $data['price'] = Basket::price($order->id);

        OrderStoreAction::run($data, $order);

        if ($data['payment'] === 'online') {
            $this->onlinePayment($data, $order->key);
        }

        return redirect()->route('client.index')->withCookie(Cookie::forget('key'));
    }

    /**
     * Викликає платіжний шлюз для онлайн-оплати замовлення.
     *
     * @param array $data
     * @param string $key
     * @return RedirectResponse
     */
    public function onlinePayment(array $data, string $key): RedirectResponse
    {
        Configuration::setMerchantId(1396424);
        Configuration::setSecretKey('test');

        $info = [
            'currency' => 'UAH',
            'amount' => $data['price'] * 100,
            'response_url' => 'http://online-store.test/order/response',
            'server_callback_url' => 'https://mighty-remotely-corgi.ngrok-free.app/webhook/order/callback',
            'merchant_data' => array(
                'order_key' => $key,
            )
        ];

        $checkoutUrl = Checkout::url($info)->toCheckout();

        return redirect($checkoutUrl);
    }

    /**
     * Обробляє відповідь від платіжного шлюзу.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleResponse(Request $request): RedirectResponse
    {
        $status = $request->input('order_status');

        return redirect()
            ->route('client.order.success')
            ->withCookie(Cookie::forget('key'));
    }

    /**
     * Показує сторінку успішної оплати замовлення.
     *
     * @return View
     */
    public function orderSuccess(): View
    {
        return view('client.orders.success');
    }

    /**
     * Обробляє зворотний виклик від платіжного шлюзу.
     *
     * @param Request $request
     * @return void
     */
    public function handleCallback(Request $request): void
    {
        $requestData = $request->all();
        $merchantData = json_decode($requestData['merchant_data'], true);
        $key = $merchantData['order_key'];

        $order = Order::where('key', '=', $key)->first();

        $order->update(['status' => 'paid']);

        Log::info('Замовлення з ключем: '.$key.' - успішно оплачене');
    }

}
