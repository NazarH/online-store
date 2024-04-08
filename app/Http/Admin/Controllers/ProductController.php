<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\FilterAction;
use App\Actions\Admin\Product\ProductCreateAction;
use App\Actions\Admin\Product\ProductEditAction;
use App\Actions\Admin\Product\ProductSortAction;
use App\Actions\Admin\Product\ProductStoreAction;
use App\Actions\Admin\Product\ProductUpdateAction;
use App\Facades\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(FilterAction $filter, string $sortBy = 'id'): View
    {
        $query = Product::query();

        if (Request::all()) {
            $query = $filter->handle($query);
        }

        $this->sortProducts($sortBy);

        $products = $query->orderBy($sortBy, Session::get('products'))->paginate(10);

        $categories = Category::get()->pluck('name', 'id')->toArray();

        $currencies = collect(Currency::show())->pluck('saleRate', 'currency')->toArray();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'currencies' => $currencies
        ]);
    }

    private function sortProducts(string $sortBy)
    {
        if ($sortBy !== 'id') {
            if (empty(Session::get('products')) || Session::get('products') === 'desc') {
                Session::put('products', 'asc');
            } else if(Session::get('products') === 'asc') {
                Session::put('products', 'desc');
            }
        } else {
            Session::put('products', 'asc');
        }
    }

    public function create(CreateRequest $request, ProductCreateAction $action): View
    {
        return view('admin.products.create', $action->handle($request));
    }

    public function store(StoreRequest $request, ProductStoreAction $action): RedirectResponse
    {
        $data = $request->validated();

        $action->handle($data);

        Cache::forget('statistic');

        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product, ProductEditAction $action): View
    {
        return view('admin.products.edit', $action->handle($product));
    }

    public function update(StoreRequest $request, Product $product, ProductUpdateAction $action): RedirectResponse
    {
        $data = $request->validated();
        $action->handle($data, $product);

        return redirect()->route('admin.products.index');
    }
}
