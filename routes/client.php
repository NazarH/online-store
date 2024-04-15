<?php

use App\Http\User\Controllers\ArticleController;
use App\Http\User\Controllers\BasketController;
use App\Http\User\Controllers\CatalogController;
use App\Http\User\Controllers\CategoryController;
use App\Http\User\Controllers\CommentController;
use App\Http\User\Controllers\HomeController;
use App\Http\User\Controllers\OrderController;
use App\Http\User\Controllers\PageController;
use App\Http\User\Controllers\PersonalController;
use App\Http\User\Controllers\ProductController;
use App\Http\User\Controllers\ReviewController;
use App\Http\User\Controllers\SearchController;
use App\Http\User\Controllers\WishlistController;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('client.catalog.index', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('client.index'));
    $trail->push('All categories', route('client.catalog.index'));
});

Breadcrumbs::for('client.catalog.category', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('client.catalog.index');
    $trail->push($category->name, route('client.catalog.category', $category->slug));
});

Route::get('')
    ->uses([HomeController::class, 'index'])
    ->name('client.index');

Route::get('/search')
    ->uses([SearchController::class, 'index'])
    ->name('client.search');

Route::group(['prefix' => 'pages'], function(){
    Route::get('/{slug}')
        ->uses([PageController::class, 'index'])
        ->name('client.pages');
});

Route::group(['prefix' => 'basket'], function(){
    Route::get('')
        ->uses([BasketController::class, 'index'])
        ->name('client.basket.index');
    Route::post('{product}')
        ->uses([BasketController::class, 'store'])
        ->name('client.basket.store');
    Route::post('{product}/update')
        ->uses([BasketController::class, 'update'])
        ->name('client.basket.update');
    Route::delete('{product}/delete')
        ->uses([BasketController::class, 'destroy'])
        ->name('client.basket.delete');
});

Route::group(['prefix' => 'catalog'], function(){
    Route::get('')
        ->uses([CatalogController::class, 'index'])
        ->name('client.catalog.index');

    Route::get('/{slug}')
        ->uses([CategoryController::class, 'index'])
        ->name('client.catalog.category');

    Route::get('/{c_slug}/{p_slug}')
        ->uses([ProductController::class, 'index'])
        ->name('client.catalog.product');

    Route::group(['prefix' => 'reviews'], function(){
        Route::post('product/{product}/')
            ->uses([ReviewController::class, 'store'])
            ->name('client.reviews.store');
    });
});

Route::group(['prefix' => 'articles'], function(){
    Route::get('')
        ->uses([ArticleController::class, 'index'])
        ->name('client.articles.index');
    Route::get('{slug}')
        ->uses([ArticleController::class, 'single'])
        ->name('client.articles.single');

    Route::group(['prefix' => 'comments'], function(){
        Route::post('article/{article}/')
            ->uses([CommentController::class, 'store'])
            ->name('client.comments.store');
    });
});

Route::group(['prefix' => 'order'], function(){
    Route::any('response')
        ->uses([OrderController::class, 'handleResponse'])
        ->name('client.order.response');
    Route::get('/success')
        ->uses([OrderController::class, 'orderSuccess'])
        ->name('client.order.success');
    Route::get('{key}')
        ->uses([OrderController::class, 'index'])
        ->name('client.order.index');
    Route::post('{order}')
        ->uses([OrderController::class, 'update'])
        ->name('client.order.update');
});

Route::group(['middleware' => 'client.auth'], function(){
    Route::group(['prefix' => 'personal'], function(){
        Route::get('')
            ->uses([PersonalController::class, 'index'])
            ->name('client.personal.index');

        Route::post('update/{user}')
            ->uses([PersonalController::class, 'update'])
            ->name('client.personal.update');
    });

    Route::group(['prefix' => 'wishlist'], function(){
        Route::get('')
            ->uses([WishlistController::class, 'index'])
            ->name('client.wishlist.index');

        Route::post('/add/{product}')
            ->uses([WishlistController::class, 'store'])
            ->name('client.wishlist.store');

        Route::delete('/delete/{product}')
            ->uses([WishlistController::class, 'destroy'])
            ->name('client.wishlist.delete');
    });
});
