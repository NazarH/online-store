<?php

namespace App\Http\Api;

use App\Actions\Api\CreatePhotoAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;


class MyController extends Controller
{
    /**
     * Get user profile information or create a new user profile.
     *
     * @api {get} /my/profile Get User Profile
     * @apiName GetUserProfile
     * @apiGroup User
     *
     * @apiSuccess {Object} profile User profile information.
     * @apiSuccess {Number} profile.id User ID.
     * @apiSuccess {String} profile.name User name.
     * @apiSuccess {String} profile.email User email.
     * @apiSuccess {String} profile.created_at User creation date.
     * @apiSuccess {String} profile.updated_at User last update date.
     *
     * @apiParam {File} avatar User avatar (for POST request).
     * @apiParam {String} name User name (for POST request).
     * @apiParam {String} email User email (for POST request).
     *
     * @apiSuccess {String} success Message indicating successful profile retrieval or creation.
     */
    public function profile(Request $request, StoreRequest $storeRequest): JsonResponse|ProfileResource
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
     * Get user's favorite items.
     *
     * @api {get} /my/favorites Get User Favorites
     * @apiName GetUserFavorites
     * @apiGroup User
     *
     * @apiSuccess {Object[]} favorites List of user's favorite items.
     * @apiSuccess {String} favorites.name Favorite item name.
     * @apiSuccess {String} favorites.price Favorite item price.
     * @apiSuccess {String} favorites.count Favorite item count.
     *
     * @apiError {String} error Message indicating unauthorized access.
     */
    public function favorites(Request $request): JsonResponse|AnonymousResourceCollection
    {
        $user = $this->userCheck($request);

        $favorites = $user->selected()->get();

        if ($user) {
            return FavoriteResource::collection($favorites);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
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
