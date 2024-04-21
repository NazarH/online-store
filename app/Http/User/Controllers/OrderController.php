<?php

namespace App\Http\User\Controllers;

use App\Actions\Order\OrderStoreAction;
use App\Facades\Basket;
use App\Facades\Order as OrderFacade;
use App\Http\Controllers\Controller;
use App\Http\User\Requests\ClientOrderStoreRequest;
use App\Models\Order;
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
     * @param ClientOrderStoreRequest $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(ClientOrderStoreRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = 'expected';
        $data['role'] = 'client';
        $data['price'] = Basket::price($order->id);

        OrderStoreAction::run($data, $order);

        if ($data['payment'] === 'online') {
            return redirect(OrderFacade::onlinePayment($data, $order->key)->toCheckout());
        }

        return redirect()->route('client.index')->withCookie(Cookie::forget('key'));
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
