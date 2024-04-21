<?php

namespace App\Http\Api;

use App\Actions\Api\CreatePhotoAction;
use App\Facades\Favorite as FavoriteFacade;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteArticleResource;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProfileResource;
use App\Http\User\Requests\UserStoreRequest;
use App\Models\Article;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    private string $product = 'App\Models\Product';
    private string $article = 'App\Models\Article';

    /**
     * Get user profile information or create a new user profile.
     *
     * @api {get} /my/profile Get User Profile
     * @apiName GetUserProfile
     * @apiGroup User
     *
     * @apiParam {File} avatar User avatar (for POST request).
     * @apiParam {String} name User name (for POST request).
     * @apiParam {String} email User email (for POST request).
     *
     */
    public function profile(Request $request, UserStoreRequest $storeRequest): JsonResponse|ProfileResource
    {
        if ($request->method() === 'GET') {
            $user = $this->userCheck($request);

            if ($user) {
                return new ProfileResource($user);
            } else {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
        } else {
            try {
                $data = $storeRequest->validated();
                $user = User::create($data);

                CreatePhotoAction::run($request, $user);

                return response()->json(['success' => 'User create success'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Bad request'], 401);
            }
        }
    }

    /**
     * Get user's orders.
     *
     * @api {get} /my/orders Get User Orders
     * @apiName GetUserOrders
     * @apiGroup User
     *
     * @apiSuccess {Object[]} orders List of user's orders.
     *
     * @apiError {String} error Message indicating unauthorized access.
     */
    public function orders(Request $request): JsonResponse|AnonymousResourceCollection
    {
        $user = $this->userCheck($request);

        $orders = $user->orders()->get();

        if ($user) {
            return OrderResource::collection($orders);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    /**
     * @api {get} /my/products Get User Favorite Products
     * @apiName GetUserFavoriteProducts
     * @apiGroup User
     *
     * @apiSuccess {Object[]} success List of user's favorite products.
     *
     * @apiParam {Request} $request Request object.
     */
    public function products(Request $request)
    {
        $user = $this->userCheck($request);

        $favorites = Favorite::where('user_id', $user->id)->where('model_type', '=', $this->product)->with('product')->get();

        $products = [];

        foreach ($favorites as $favorite)
        {
            $products[] = new FavoriteResource($favorite->product);
        }

        return response()->json(['success' => $products], 200);
    }

    /**
     * @api {get} /my/articles Get User Favorite Articles
     * @apiName GetUserFavoriteArticles
     * @apiGroup User
     *
     * @apiSuccess {Object[]} success List of user's favorite articles.
     *
     * @apiParam {Request} $request Request object.
     *
     */
    public function articles(Request $request)
    {
        $user = $this->userCheck($request);

        $favorites = Favorite::where('user_id', $user->id)->where('model_type', '=', $this->article)->with('article')->get();

        $articles = [];

        foreach ($favorites as $favorite)
        {
            $articles[] = new FavoriteArticleResource($favorite->article);
        }
        return response()->json(['success' => $articles], 200);
    }

    /**
     * @api {post} /my/product Toggle Favorite Product
     * @apiName ToggleFavoriteProduct
     * @apiGroup User
     *
     * @apiParam {Request} $request Request object.
     */
    public function product(Request $request)
    {
        $user_id = $this->userCheck($request)->id;
        $product = Product::find($request->product);

        return FavoriteFacade::toggle($product, $user_id);
    }

    /**
     * @api {post} /my/article Toggle Favorite Article
     * @apiName ToggleFavoriteArticle
     * @apiGroup User
     *
     * @apiParam {Request} $request Request object.
     */
    public function article(Request $request)
    {
        $user_id = $this->userCheck($request)->id;
        $article = Article::find($request->article);

        return FavoriteFacade::toggle($article, $user_id);
    }

    /**
     * Перевіряє автентифікацію користувача та повертає об'єкт користувача.
     *
     * @param Request $request
     * @return Authenticatable
     */
    private function userCheck($request): Authenticatable
    {
        $request->bearerToken();

        return Auth::guard('sanctum')->user();
    }
}
