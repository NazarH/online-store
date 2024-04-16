<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\FilterAction;
use App\Actions\Admin\Product\ProductCreateAction;
use App\Actions\Admin\Product\ProductEditAction;
use App\Actions\Admin\Product\ProductStoreAction;
use App\Actions\Admin\Product\ProductUpdateAction;
use App\Actions\Admin\Product\UploadFileAction;
use App\Facades\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Models\Category;
use App\Models\Photo;
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
     * @return View
     */
    public function create(CreateRequest $request): View
    {
        return view('admin.products.create', ProductCreateAction::run($request));
    }

    /**
     * Зберігає новий продукт в базі даних.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $files = $request->allFiles()['images'];

        $product = ProductStoreAction::run($data);

        UploadFileAction::run($files, $product->id);

        Cache::forget('statistic');

        return redirect()->route('admin.products.index');
    }

    /**
     * Показує форму для редагування конкретного продукту.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        return view('admin.products.edit', ProductEditAction::run($product));
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
        $files = $request->allFiles()['images'];

        ProductUpdateAction::run($data, $product);

        UploadFileAction::run($files, $product->id);

        $product->seo()->updateOrCreate(['tags' => $data['seo']]);

        return redirect()->route('admin.products.index');
    }

    /**
     * Видаляє зображення та перенаправляє користувача на попередню сторінку.
     *
     * @param Photo $image Зображення, яке потрібно видалити
     * @return RedirectResponse Перенаправлення на попередню сторінку
     */
    public function imageDelete(Photo $image): RedirectResponse
    {
        $image->delete();

        return redirect()->back();

    }
}
