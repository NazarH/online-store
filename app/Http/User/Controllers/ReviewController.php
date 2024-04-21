<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\User\Requests\ReviewStoreRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Зберігає новий коментар для продукту.
     *
     * @param ReviewStoreRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(ReviewStoreRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['product_id'] = $product->id;

        $comment = Comment::create($data);

        Auth::user()->review()->attach($comment->id);

        return redirect()->route('client.catalog.product', [
            'c_slug' => $product->category()->first()->slug,
            'p_slug' => $product->slug
        ]);
    }
}
