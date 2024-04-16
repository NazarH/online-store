<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Order\OrderStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Показує список замовлень.
     *
     * @return View
     */
    public function index(): View
    {
        $orders = Order::query()->with('user')->paginate(10);

        return view('admin.orders.index', ['orders' => $orders]);
    }

    /**
     * Показує форму для створення нового замовлення.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.orders.create');
    }

    /**
     * Зберігає нове замовлення в базі даних.
     *
     * @param UpdateRequest $request
     * @return RedirectResponse
     */
    public function store(UpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        OrderStoreAction::run($data);

        Cache::forget('statistic');

        return redirect()->route('admin.orders.index');
    }

    /**
     * Показує форму для редагування конкретного замовлення.
     *
     * @param Order $order
     * @return View
     */
    public function edit(Order $order): View
    {
        return view('admin.orders.edit', ['order' => $order]);
    }

    /**
     * Оновлює існуюче замовлення в базі даних.
     *
     * @param UpdateRequest $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();

        $order->update($data);

        return redirect()->route('admin.orders.index');
    }

    /**
     * Видаляє конкретне замовлення з бази даних.
     *
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        Cache::forget('statistic');

        return redirect()->route('admin.orders.index');
    }
}
