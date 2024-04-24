<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Brand\BrandStoreAction;
use App\Actions\Brand\BrandUpdateAction;
use App\Http\Admin\Requests\BrandStoreRequest;
use App\Http\Controllers\Controller;
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
     * @param BrandStoreRequest $request
     * @return RedirectResponse
     */
    public function store(BrandStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        BrandStoreAction::run($data);

        return redirect()->route('brands.index');
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
     * @param BrandStoreRequest $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function update(BrandStoreRequest $request, Brand $brand): RedirectResponse
    {
        $data = $request->validated();
        BrandUpdateAction::run($data, $brand);

        return redirect()->back();
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

        return redirect()->back();
    }
}
