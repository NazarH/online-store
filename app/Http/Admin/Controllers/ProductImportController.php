<?php

namespace App\Http\Admin\Controllers;

use App\Http\Admin\Requests\ProductImportRequest;
use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{
    /**
     * Метод для імпорту даних з Excel-файлу.
     *
     * @return RedirectResponse
     */
    public function __invoke(ProductImportRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Excel::import(new ProductImport(), $data['file']);

        return redirect()->back();
    }
}
