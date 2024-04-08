<?php

namespace App\Http\Admin\Controllers;

use App\Exports\MarkerExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function __invoke()
    {
        return Excel::download(new MarkerExport(), 'export-market.xlsx');
    }
}
