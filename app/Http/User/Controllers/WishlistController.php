<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Favorite;
use App\Facades\Favorite as FavoriteFacade;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WishlistController extends Controller
{
    private string $product = 'App\Models\Product';
    private string $article = 'App\Models\Article';
    /**
     * Відображає сторінку бажаних товарів користувача.
     *
     * @return View
     */
    public function index(): View
    {
        return view('client.wishlist.index');
    }

    public function products()
    {
        $favorites = Favorite::where('user_id', auth()->id())->where('model_type', '=', $this->product)->with('product')->paginate(9);

        return view('client.wishlist.products.index', ['favorites' => $favorites]);
    }

    public function articles()
    {
        $favorites = Favorite::where('user_id', auth()->id())->where('model_type', '=', $this->article)->with('article')->paginate(9);

        return view('client.wishlist.articles.index', ['favorites' => $favorites]);
    }

    public function product(Product $product)
    {
        FavoriteFacade::toggle($product);

        return redirect()->route('client.wishlist.index');
    }

    public function article(Article $article)
    {
        FavoriteFacade::toggle($article);

        return redirect()->route('client.wishlist.index');
    }
}
