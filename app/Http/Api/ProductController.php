<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReviewRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Get all products or filter and sort products.
     *
     * @api {get} /products Get All Products
     * @apiName GetProducts
     * @apiGroup Products
     *
     * @apiParam {String} [sort] Field to sort by (e.g., "name", "price").
     * @apiParam {String} [order] Sort order ("asc" or "desc").
     *
     */
    public function products(Request $request): AnonymousResourceCollection
    {
        $query = $request->all();

        if ($query) {
            $products = Product::filter()->orderBy($query['sort'], $query['order'])->get();
        } else {
            $products = Product::get();
        }

        return ProductResource::collection($products);
    }

    /**
     * Search for products by name.
     *
     * @api {get} /products/search Search Products
     * @apiName SearchProducts
     * @apiGroup Products
     *
     * @apiParam {String} q Search query for product name.
     *
     * @apiSuccess {Object[]} products List of products matching the search query.
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $query = $request->input('q');
        $results = Product::where('name', 'like', '%'.$query.'%')->get();

        return ProductResource::collection($results);
    }

    /**
     * Get a specific product by slug.
     *
     * @api {get} /products/:slug Get Product by Slug
     * @apiName GetProductBySlug
     * @apiGroup Products
     *
     * @apiParam {String} slug Product slug.
     *
     * @apiSuccess {Number} id Product ID.
     * @apiSuccess {String} name Product name.
     * @apiSuccess {Number} price Product price.
     * @apiSuccess {Number} old_price Product old price.
     * @apiSuccess {Number} article Product article.
     * @apiSuccess {Number} count Product count.
     * @apiSuccess {Number} slug Product slug.
     */
    public function product(Request $request): ProductResource
    {
        $product = Product::where('slug', '=', $request->slug)->first();

        return new ProductResource($product);
    }

    /**
     * Get reviews for a specific product.
     *
     * @api {get} /products/:id/reviews Get Product Reviews
     * @apiName GetProductReviews
     * @apiGroup Products
     *
     * @apiParam {Number} id Product ID.
     *
     * @apiSuccess {Object[]} reviews List of reviews for the product.
     */
    public function reviews(int $id): AnonymousResourceCollection|JsonResponse
    {
        try {
            $product = Product::findOrFail($id);

            $reviews = $product->reviews()->get();

            return ReviewResource::collection($reviews);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Product not found']);
        }
    }

    /**
     * Store a new review for a specific product.
     *
     * @api {post} /products/:id/review Store Product Review
     * @apiName StoreProductReview
     * @apiGroup Products
     *
     * @apiParam {Number} id Product ID.
     * @apiParam {String} comment Review comment.
     *
     * @apiSuccess {String} success Message indicating successful review submission.
     * @apiError {String} error Message indicating failure to store the review.
     */
    public function store(ReviewRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $product = Product::findOrFail($id);

            $data['product_id'] = $product->id;

            Comment::create($data);

            return response()->json(['success' => 'Review saved successfully.']);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Review not found.']);
        }
    }
}
