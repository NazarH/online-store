<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $page = StaticPage::where('slug', '=', $request->slug)->first();
        $pages = StaticPage::get();

        return view('client.pages.'.$page->type, ['page' => $page, 'pages' => $pages]);
    }
}
