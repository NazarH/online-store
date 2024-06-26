<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Відображає сторінку продукту разом з коментарями.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $product = Product::where('slug', '=', $request->p_slug)->first();

        $images = $product->getMedia('images')->map(function ($image) {
            return $image->getUrl();
        });

        $comments = Comment::where('product_id', '=', $product->id)->paginate(5);

        return view('client.catalog.products.index', ['product' => $product, 'comments' => $comments, 'images' => $images]);
    }
}
