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
    /**
     * Показує список продуктів з можливістю фільтрації та сортування.
     *
     * @param FilterAction $filter
     * @param string $sortBy
     * @return View
     */
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

    /**
     * Сортує продукти в залежності від обраного поле та порядку сортування.
     *
     * @param string $sortBy
     * @return void
     */
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

    /**
     * Показує форму для створення нового продукту.
     *
     * @param CreateRequest $request
     * @param ProductCreateAction $action
     * @return View
     */
    public function create(CreateRequest $request, ProductCreateAction $action): View
    {
        return view('admin.products.create', $action->handle($request));
    }

    /**
     * Зберігає новий продукт в базі даних.
     *
     * @param StoreRequest $request
     * @param ProductStoreAction $action
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, ProductStoreAction $action): RedirectResponse
    {
        $data = $request->validated();

        $action->handle($data);

        Cache::forget('statistic');

        return redirect()->route('admin.products.index');
    }

    /**
     * Показує форму для редагування конкретного продукту.
     *
     * @param Product $product
     * @param ProductEditAction $action
     * @return View
     */
    public function edit(Product $product, ProductEditAction $action): View
    {
        return view('admin.products.edit', $action->handle($product));
    }

    /**
     * Оновлює існуючий продукт в базі даних.
     *
     * @param StoreRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(StoreRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        ProductUpdateAction::run($data, $product);

        $product->seo()->updateOrCreate(['tags' => $data['seo']]);

        return redirect()->route('admin.products.index');
    }
}
