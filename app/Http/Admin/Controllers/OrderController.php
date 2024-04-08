<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Order\OrderStoreAction;
use App\Actions\Admin\Order\OrderUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()->with('user')->paginate(10);

        return view('admin.orders.index', ['orders' => $orders]);
    }

    public function create(): View
    {
        return view('admin.orders.create');
    }

    public function store(UpdateRequest $request, OrderStoreAction $action): RedirectResponse
    {
        $data = $request->validated();

        $action->handle($data);

        Cache::forget('statistic');

        return redirect()->route('admin.orders.index');
    }

    public function edit(Order $order): View
    {
        return view('admin.orders.edit', ['order' => $order]);
    }

    public function update(UpdateRequest $request, Order $order): RedirectResponse
    {
        $data = $request->validated();

        $order->update($data);

        return redirect()->route('admin.orders.index');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        Cache::forget('statistic');

        return redirect()->route('admin.orders.index');
    }
}
