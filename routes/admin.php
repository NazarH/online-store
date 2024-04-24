<?php

use App\Http\Admin\Controllers\ArticleController;
use App\Http\Admin\Controllers\AttributeController;
use App\Http\Admin\Controllers\BrandController;
use App\Http\Admin\Controllers\CategoryController;
use App\Http\Admin\Controllers\ExportController;
use App\Http\Admin\Controllers\HomeController;
use App\Http\Admin\Controllers\ProductImportController;
use App\Http\Admin\Controllers\LeadController;
use App\Http\Admin\Controllers\NotificationController;
use App\Http\Admin\Controllers\OrderController;
use App\Http\Admin\Controllers\ProductController;
use App\Http\Admin\Controllers\StaticController;
use App\Http\Admin\Controllers\UserController;
use App\Http\Admin\Controllers\XmlGenerateController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

//Route::view('admin', 'admin.examples.home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth.role'], function(){
    Route::get('')
        ->uses([HomeController::class, '__invoke'])
        ->name('admin.home');

    Route::get('iframe')
        ->uses([LogViewerController::class, 'index'])
        ->name('admin.iframe');

    Route::get('export')
        ->uses([ExportController::class, '__invoke'])
        ->name('admin.export');

    Route::get('xml-generate')
        ->uses([XmlGenerateController::class, '__invoke'])
        ->name('admin.xml.generate');

    Route::post('import')
        ->uses([ProductImportController::class, '__invoke'])
        ->name('admin.import');

    Route::get('logs')
        ->uses([HomeController::class, 'logs'])
        ->name('admin.logs');

    //USERS
    Route::resource('users', UserController::class)->parameters([
        'users' => 'user'
    ])->only(['create', 'store', 'edit', 'update', 'destroy', 'index']);

    //CATEGORIES
    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category'
    ])->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);
    Route::post('categories/order', [CategoryController::class, 'order'])
        ->name('categories.order');


    //ATTRIBUTES
    Route::resource('attributes', AttributeController::class)->parameters([
        'attributes' => 'attribute'
    ])->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);
    Route::post('/add-value/{attribute}')
        ->uses([AttributeController::class, 'add'])
        ->name('admin.attributes.add');

    //BRANDS
    Route::resource('brands', BrandController::class)->parameters([
        'brands' => 'brand'
    ])->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);

    //PRODUCTS
    Route::resource('products', ProductController::class)->parameters([
        'products' => 'product'
    ])->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);
    Route::delete('image/{image}/delete')
        ->uses([ProductController::class, 'imageDelete'])
        ->name('admin.products.image.delete');

    //ORDERS
    Route::resource('orders', OrderController::class)->parameters([
        'orders' => 'order'
    ])->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);

    //ARTICLES
    Route::resource('news', ArticleController::class)->parameters([
        'news' => 'article'
    ])->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);

    //STATIC PAGES
    Route::resource('static', StaticController::class)->parameters([
        'static' => 'page'
    ])->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);
    Route::delete('/upload')
        ->uses([StaticController::class, 'upload'])
        ->name('admin.static.upload');

    //LEADS
    Route::resource('leads', LeadController::class)->parameters([
        'leads' => 'lead'
    ])->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);

    //NOTIFICATIONS
    Route::group(['prefix' => 'leads'], function(){
        Route::resource('notifications', NotificationController::class)->parameters([
            'notifications' => 'notification'
        ])->only([
            'index', 'create', 'edit', 'update', 'destroy'
        ]);
        Route::post('/send')
            ->uses([NotificationController::class, 'send'])
            ->name('notifications.send');
    });

    Route::group(['prefix' => 'metatags'], function(){
        Route::post('{item}/store')
            ->uses([MetaController::class, 'store'])
            ->name('admin.products.metatags');
    });
});
