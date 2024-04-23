<?php

namespace App\Http\Admin\Controllers;

use App\Actions\FilterAction;
use App\Actions\Product\ProductCreateAction;
use App\Actions\Product\ProductEditAction;
use App\Actions\Product\ProductStoreAction;
use App\Actions\Product\ProductUpdateAction;
use App\Facades\Currency;
use App\Http\Admin\Requests\ProductCreateRequest;
use App\Http\Admin\Requests\ProductStoreRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use Fomvasss\MediaLibraryExtension\MediaManager;
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
     * @param ProductCreateRequest $request
     * @return View
     */
    public function create(ProductCreateRequest $request): View
    {
        return view('admin.products.create', ProductCreateAction::run($request));
    }

    /**
     * Зберігає новий продукт в базі даних.
     *
     * @param ProductStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $product = ProductStoreAction::run($data);

        $product->mediaManage($request);

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
     * @param ProductStoreRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductStoreRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

      // if (!empty($request->allFiles()['images'])) {
      //      $files = $request->allFiles()['images'];
        //    UploadFileAction::run($files, $product->id);
        //}
        $product->mediaManage($request);

        ProductUpdateAction::run($data, $product);
        $product->seo()->updateOrCreate(['tags' => $data['seo']]);

        return redirect()->back();
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

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->back();
    }
}
