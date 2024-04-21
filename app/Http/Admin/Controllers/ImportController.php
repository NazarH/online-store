<?php

namespace App\Http\Admin\Controllers;

use App\Http\Admin\Requests\ProductImportRequest;
use App\Http\Controllers\Controller;
use App\Imports\MarketImport;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Метод для імпорту даних з Excel-файлу.
     *
     * @return RedirectResponse
     */
    public function __invoke(ProductImportRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Excel::import(new MarketImport(), $data['file']);

        return redirect()->back();
    }
}
