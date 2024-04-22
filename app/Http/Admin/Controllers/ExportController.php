<?php

namespace App\Http\Admin\Controllers;

use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    /**
     * Метод для завантаження Excel-файлу з даними.
     *
     * @return BinaryFileResponse
     */
    public function __invoke(): BinaryFileResponse
    {
        return Excel::download(new ProductExport(), 'export-market.xlsx');
    }
}
