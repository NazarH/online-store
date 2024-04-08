<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $products = Auth::user()->selected()->paginate(9);

        return view('client.wishlist.index', ['products' => $products]);
    }

    public function store(Product $product): RedirectResponse
    {
        Auth::user()->selected()->attach($product->id);

        return redirect()->route('client.wishlist.index');
    }

    public function destroy(Product $product): RedirectResponse
    {
        Auth::user()->selected()->detach($product->id);

        return redirect()->route('client.wishlist.index');
    }
}
