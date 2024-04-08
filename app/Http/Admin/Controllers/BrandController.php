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
    public function index(): View
    {
        $brands = Brand::query()->withTrashed()->paginate(10);

        return view('admin.brands.index', ['brands' => $brands]);
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(StoreRequest $request, BrandStoreAction $action): RedirectResponse
    {
        $data = $request->validated();
        $action->handle($data);

        return redirect()->route('admin.brands.index');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', ['brand' => $brand]);
    }

    public function update(StoreRequest $request, Brand $brand, BrandUpdateAction $action): RedirectResponse
    {
        $data = $request->validated();
        $action->handle($data, $brand);

        return redirect()->route('admin.brands.index');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return redirect()->route('admin.brands.index');
    }
}
