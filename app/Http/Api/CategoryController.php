<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Get all categories.
     *
     * @api {get} /categories Get All Categories
     * @apiName GetAllCategories
     * @apiGroup Categories
     *
     */
    public function all(): AnonymousResourceCollection
    {
        $categories = Category::get();

        return CategoryResource::collection($categories);
    }

    /**
     * Get a specific category by slug.
     *
     * @api {get} /categories/:slug Get Category by Slug
     * @apiName GetCategoryBySlug
     * @apiGroup Categories
     *
     * @apiParam {String} slug Category slug.
     *
     */
    public function category(Request $request): CategoryResource
    {
        $category = Category::where('slug', '=', $request->slug)->first();

        return new CategoryResource($category);
    }
}
