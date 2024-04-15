<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Brand\BrandStoreAction;
use App\Actions\Admin\Brand\BrandUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BrandController extends Controller
{
    /**
     * Показує список брендів.
     *
     * @return View
     */
    public function index(): View
    {
        $brands = Brand::query()->withTrashed()->paginate(10);

        return view('admin.brands.index', ['brands' => $brands]);
    }

    /**
     * Показує форму для створення нового бренду.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.brands.create');
    }

    /**
     * Зберігає новий бренд в базі даних.
     *
     * @param StoreRequest $request
     * @param BrandStoreAction $action
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, BrandStoreAction $action): RedirectResponse
    {
        $data = $request->validated();
        $action->handle($data);

        return redirect()->route('admin.brands.index');
    }

    /**
     * Показує форму для редагування конкретного бренду.
     *
     * @param Brand $brand
     * @return View
     */
    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', ['brand' => $brand]);
    }

    /**
     * Оновлює існуючий бренд в базі даних.
     *
     * @param StoreRequest $request
     * @param Brand $brand
     * @param BrandUpdateAction $action
     * @return RedirectResponse
     */
    public function update(StoreRequest $request, Brand $brand, BrandUpdateAction $action): RedirectResponse
    {
        $data = $request->validated();
        $action->handle($data, $brand);

        return redirect()->route('admin.brands.index');
    }

    /**
     * Видаляє конкретний бренд з бази даних.
     *
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return redirect()->route('admin.brands.index');
    }
}
