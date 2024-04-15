<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\SearchRequest;
use App\Models\Product;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Відображає сторінку з результатами пошуку продуктів.
     *
     * @param SearchRequest $request
     * @return View
     */
    public function index(SearchRequest $request): View
    {
        $data = $request->validated();

        $products = Product::where('name', 'like', '%'.$data['search'].'%')->paginate(9);

        return view('client.search.index', ['products' => $products]);
    }
}
