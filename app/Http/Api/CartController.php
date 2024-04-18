<?php

namespace App\Http\Api;

use App\Facades\Basket;
use App\Facades\Order as OrderFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ShipmentRequest;
use App\Http\Resources\CartResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartController extends Controller
{
    /**
     * Retrieve the user's cart.
     *
     * @api {get} /cart Retrieve Cart
     * @apiName RetrieveCart
     * @apiGroup Cart
     *
     * @apiSuccess {Object[]} products List of products in the cart.
     * @apiSuccess {String} products.name Product name.
     * @apiSuccess {Number} products.price Product price.
     */
    public function cart(Request $request): JsonResponse|ResourceCollection|NULL
    {
        try {
            $user = $this->userCheck($request);

            $cart = $this->orderReturn($user);

            $products = $cart?->products()->get();

            if ($cart) {
                return CartResource::collection($products);
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    /**
     * Add a product to the user's cart.
     *
     * @api {post} /cart/:productId/add Product Add to Cart
     * @apiName AddProductToCart
     * @apiGroup Cart
     *
     * @apiParam {Number} productId Product ID.
     *
     * @apiSuccess {String} success Message indicating successful addition.
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $user = $this->userCheck($request);

            $cart = $this->orderReturn($user);

            if(empty($cart)){
                $key = Str::random(40);

                $cart = Order::create([
                    'type' => 'basket',
                    'key' => $key,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]);
            }

            $product = Product::where('id', '=', $request->productId)->first();

            $cart->products()->attach($product->id);

            Basket::search($cart->id, $product->id)->update(['price' => $product->price]);

            return response()->json(['success' => 'Add successful'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bad request'], 401);
        }
    }

    /**
     * Remove a product from the user's cart.
     *
     * @api {post} /cart/:productId/remove Product Remove from Cart
     * @apiName RemoveProductFromCart
     * @apiGroup Cart
     *
     * @apiParam {Number} productId Product ID.
     *
     * @apiSuccess {String} success Message indicating successful removal.
     */
    public function remove(Request $request): JsonResponse
    {
        try {
            $user = $this->userCheck($request);

            $cart = $this->orderReturn($user);

            $cart->products()->detach($request->productId);

            return response()->json(['success' => 'Remove successful'], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Bad request'], 401);
        }
    }

    /**
     * Update shipping details for the user's cart.
     *
     * @api {post} /cart/shipping Update Shipping Details
     * @apiName UpdateShippingDetails
     * @apiGroup Cart
     *
     * @apiParam {String} address Shipping address.
     * @apiParam {String} city Shipping city.
     * @apiParam {String} country Shipping country.
     *
     * @apiSuccess {String} success Message indicating successful update.
     */
    public function shipping(ShipmentRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $user = $this->userCheck($request);

            $order = $this->orderReturn($user);
            dd($user, $order, $data);
            $order->update($data);

            return response()->json(['success' => 'Update successful'], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Bad request'], 401);
        }
    }

    /**
     * Checkout the user's cart.
     *
     * @api {post} /cart/checkout Cart Checkout
     * @apiName CheckoutCart
     * @apiGroup Cart
     *
     * @apiSuccess {String} success Message indicating successful checkout.
     */
    public function checkout(Request $request): JsonResponse|string
    {
        try {
            $user = $this->userCheck($request);

            $order = $this->orderReturn($user);

            $order->update([
                'type' => 'order',
                'payment' => $request->payment,
                'price' => $order->products()->get()->sum('price')
            ]);

            if ($request->payment === 'online') {
                return OrderFacade::onlinePayment($order->toArray(), $order->key)->getUrl();
            }

            return response()->json(['success' => 'Update successful'], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Bad request'], 401);
        }
    }

    /**
     * Перевіряє автентифікацію користувача та повертає об'єкт користувача.
     *
     * @param Request $request
     * @return Authenticatable
     */
    private function userCheck(Request $request): Authenticatable
    {
        $request->bearerToken();

        return Auth::guard('sanctum')->user();
    }

    /**
     * Повертає останнє замовлення користувача.
     *
     * @param Authenticatable $user
     * @return Order|NULL
     */
    private function orderReturn(Authenticatable $user): Order|NULL
    {
        return Order::where('user_id', '=', $user->id)->latest()->first();
    }
}
