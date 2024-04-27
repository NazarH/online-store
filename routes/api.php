<?php

use App\Http\Api\AuthController;
use App\Http\Api\CartController;
use App\Http\Api\CategoryController;
use App\Http\Api\ElasticSearchController;
use App\Http\Api\LocationController;
use App\Http\Api\ProfileController;
use App\Http\Api\PageController;
use App\Http\Api\ProductController;
use App\Http\Api\SubscribeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
*/

Route::get('/locations/search')
    ->uses([LocationController::class, 'search']);

Route::get('/page/{slug}')
    ->uses([PageController::class, 'page']);

Route::post('/subscribe')
    ->uses([SubscribeController::class, 'subscribe']);

Route::group(['prefix' => 'categories'], function(){
    Route::get('')
        ->uses([CategoryController::class, 'all']);
    Route::get('{slug}')
        ->uses([CategoryController::class, 'category']);
});

Route::group(['prefix' => 'products'], function(){
    Route::get('')
        ->uses([ProductController::class, 'products']);
    Route::get('search')
        ->uses([ProductController::class, 'search']);
    Route::get('{slug}')
        ->uses([ProductController::class, 'product']);
    Route::get('{id}/reviews')
        ->uses([ProductController::class, 'reviews']);
    Route::post('{id}/review')
        ->uses([ProductController::class, 'store']);
});

Route::group(['prefix' => 'auth'], function(){
    Route::post('login')
        ->uses([AuthController::class, 'login']);
    Route::post('register')
        ->uses([AuthController::class, 'register']);
    Route::post('password/email')
        ->uses([AuthController::class, 'email']);
    Route::post('password/reset')
        ->uses([AuthController::class, 'reset']);

});

Route::group(['prefix' => 'my'], function(){
    Route::match(['GET', 'POST'], 'profile')
        ->uses([ProfileController::class, 'profile']);
    Route::get('orders')
        ->uses([ProfileController::class, 'orders']);

    Route::group(['prefix' => 'favorites'], function(){
        Route::group(['prefix' => 'products'], function(){
            Route::get('')
                ->uses([ProfileController::class, 'products']);
            Route::post('{product}')
                ->uses([ProfileController::class, 'product']);
        });
        Route::group(['prefix' => 'articles'], function(){
            Route::get('')
                ->uses([ProfileController::class, 'articles']);
            Route::post('{article}')
                ->uses([ProfileController::class, 'article']);
        });
    });

});

Route::group(['prefix' => 'cart'], function(){
    Route::get('')
        ->uses([CartController::class, 'cart']);
    Route::post('shipping')
        ->uses([CartController::class, 'shipping']);
    Route::post('checkout')
        ->uses([CartController::class, 'checkout']);
    Route::post('{productId}/add')
        ->uses([CartController::class, 'add']);
    Route::post('{productId}/remove')
        ->uses([CartController::class, 'remove']);
});

Route::group(['prefix' => 'elastic'], function(){
    Route::get('search')
        ->uses([ElasticSearchController::class, 'search']);
    Route::get('filter-by-category-id')
        ->uses([ElasticSearchController::class, 'filterByCategoryId']);
    Route::get('filter-by-price-range')
        ->uses([ElasticSearchController::class, 'filterByPriceRange']);
    Route::get('sorting-by-field')
        ->uses([ElasticSearchController::class, 'sortingByField']);
});


