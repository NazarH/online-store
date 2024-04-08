<?php

namespace App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\MarketImport;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        Excel::import(new MarketImport(), 'excel/export-market.xlsx');

        return redirect()->route('admin.products.index');
    }
}
