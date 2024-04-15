<?php

use App\Http\Admin\Controllers\ArticleController;
use App\Http\Admin\Controllers\AttributeController;
use App\Http\Admin\Controllers\BrandController;
use App\Http\Admin\Controllers\CategoryController;
use App\Http\Admin\Controllers\ExportController;
use App\Http\Admin\Controllers\HomeController;
use App\Http\Admin\Controllers\ImportController;
use App\Http\Admin\Controllers\LeadController;
use App\Http\Admin\Controllers\NotificationController;
use App\Http\Admin\Controllers\OrderController;
use App\Http\Admin\Controllers\ProductController;
use App\Http\Admin\Controllers\StaticController;
use App\Http\Admin\Controllers\UserController;
use App\Http\Admin\Controllers\XmlGenerateController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

//Route::view('admin', 'admin.examples.home');

Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth'], function(){
    Route::get('logs')
        ->uses([LogViewerController::class, 'index'])
        ->name('admin.logs');

    Route::get('export')
        ->uses([ExportController::class, '__invoke'])
        ->name('admin.export');

    Route::get('xml-generate')
        ->uses([XmlGenerateController::class, '__invoke'])
        ->name('admin.xml.generate');

    Route::get('import')
        ->uses([ImportController::class, '__invoke'])
        ->name('admin.import');

    Route::get('')
        ->uses([HomeController::class, '__invoke'])
        ->name('admin.home');

    Route::group(['prefix' => 'users'], function(){
        Route::get('/create')
            ->uses([UserController::class, 'create'])
            ->name('admin.users.create');
        Route::post('/store')
            ->uses([UserController::class, 'store'])
            ->name('admin.users.store');
        Route::get('/edit/{user}')
            ->uses([UserController::class, 'edit'])
            ->name('admin.users.edit');
        Route::post('/update/{user}')
            ->uses([UserController::class, 'update'])
            ->name('admin.users.update');
        Route::delete('/delete/{user}')
            ->uses([UserController::class, 'destroy'])
            ->name('admin.users.delete');
        Route::get('/{sortBy?}')
            ->uses([UserController::class, 'index'])
            ->name('admin.users.index');
    });

    Route::group(['prefix' => 'categories'], function(){
        Route::get('')
            ->uses([CategoryController::class, 'index'])
            ->name('admin.categories.index');
        Route::get('/create')
            ->uses([CategoryController::class, 'create'])
            ->name('admin.categories.create');
        Route::post('/store')
            ->uses([CategoryController::class, 'store'])
            ->name('admin.categories.store');
        Route::get('/edit/{category}')
            ->uses([CategoryController::class, 'edit'])
            ->name('admin.categories.edit');
        Route::post('/update/{category}')
            ->uses([CategoryController::class, 'update'])
            ->name('admin.categories.update');
        Route::post('/order')
            ->uses([CategoryController::class, 'order'])
            ->name('admin.categories.order');
        Route::delete('/delete/{category}')
            ->uses([CategoryController::class, 'destroy'])
            ->name('admin.categories.delete');
    });

    Route::group(['prefix' => 'attributes'], function(){
        Route::get('')
            ->uses([AttributeController::class, 'index'])
            ->name('admin.attributes.index');
        Route::get('/create')
            ->uses([AttributeController::class, 'create'])
            ->name('admin.attributes.create');
        Route::post('/store')
            ->uses([AttributeController::class, 'store'])
            ->name('admin.attributes.store');
        Route::get('/edit/{attribute}')
            ->uses([AttributeController::class, 'edit'])
            ->name('admin.attributes.edit');
        Route::post('/add-value/{attribute}')
            ->uses([AttributeController::class, 'add'])
            ->name('admin.attributes.add');
        Route::post('/update/{attribute}')
            ->uses([AttributeController::class, 'update'])
            ->name('admin.attributes.update');
        Route::delete('/delete/{attribute}')
            ->uses([AttributeController::class, 'destroy'])
            ->name('admin.attributes.delete');
    });


    Route::group(['prefix' => 'brands'], function(){
        Route::get('')
            ->uses([BrandController::class, 'index'])
            ->name('admin.brands.index');
        Route::get('/create')
            ->uses([BrandController::class, 'create'])
            ->name('admin.brands.create');
        Route::post('/store')
            ->uses([BrandController::class, 'store'])
            ->name('admin.brands.store');
        Route::get('/edit/{brand}')
            ->uses([BrandController::class, 'edit'])
            ->name('admin.brands.edit');
        Route::post('/update/{brand}')
            ->uses([BrandController::class, 'update'])
            ->name('admin.brands.update');
        Route::delete('/delete/{brand}')
            ->uses([BrandController::class, 'destroy'])
            ->name('admin.brands.delete');
    });

    Route::group(['prefix' => 'products'], function(){
        Route::get('/create')
            ->uses([ProductController::class, 'create'])
            ->name('admin.products.create');
        Route::post('/store')
            ->uses([ProductController::class, 'store'])
            ->name('admin.products.store');
        Route::get('/edit/{product}')
            ->uses([ProductController::class, 'edit'])
            ->name('admin.products.edit');
        Route::post('/edit/{product}')
            ->uses([ProductController::class, 'update'])
            ->name('admin.products.update');
        Route::get('/{sortBy?}')
            ->uses([ProductController::class, 'index'])
            ->name('admin.products.index');
    });

    Route::group(['prefix' => 'orders'], function(){
        Route::get('')
            ->uses([OrderController::class, 'index'])
            ->name('admin.orders.index');
        Route::get('/create')
            ->uses([OrderController::class, 'create'])
            ->name('admin.orders.create');
        Route::post('/store')
            ->uses([OrderController::class, 'store'])
            ->name('admin.orders.store');
        Route::get('/edit/{order}')
            ->uses([OrderController::class, 'edit'])
            ->name('admin.orders.edit');
        Route::post('/update/{order}')
            ->uses([OrderController::class, 'update'])
            ->name('admin.orders.update');
        Route::delete('/delete/{order}')
            ->uses([OrderController::class, 'destroy'])
            ->name('admin.orders.delete');
    });

    Route::group(['prefix' => 'news'], function(){
        Route::get('')
            ->uses([ArticleController::class, 'index'])
            ->name('admin.news.index');
        Route::get('/create')
            ->uses([ArticleController::class, 'create'])
            ->name('admin.news.create');
        Route::post('/store')
            ->uses([ArticleController::class, 'store'])
            ->name('admin.news.store');
        Route::get('/edit/{article}')
            ->uses([ArticleController::class, 'edit'])
            ->name('admin.news.edit');
        Route::post('/update/{article}')
            ->uses([ArticleController::class, 'update'])
            ->name('admin.news.update');
        Route::delete('/delete/{article}')
            ->uses([ArticleController::class, 'destroy'])
            ->name('admin.news.delete');
    });

    Route::group(['prefix' => 'static'], function(){
        Route::get('')
            ->uses([StaticController::class, 'index'])
            ->name('admin.static.index');
        Route::get('/create')
            ->uses([StaticController::class, 'create'])
            ->name('admin.static.create');
        Route::post('/store')
            ->uses([StaticController::class, 'store'])
            ->name('admin.static.store');
        Route::get('/edit/{page}')
            ->uses([StaticController::class, 'edit'])
            ->name('admin.static.edit');
        Route::post('/update/{page}')
            ->uses([StaticController::class, 'update'])
            ->name('admin.static.update');
        Route::delete('/delete/{page}')
            ->uses([StaticController::class, 'destroy'])
            ->name('admin.static.delete');
        Route::delete('/upload')
            ->uses([StaticController::class, 'upload'])
            ->name('admin.static.upload');
    });

    Route::group(['prefix' => 'leads'], function(){
        Route::get('')
            ->uses([LeadController::class, 'index'])
            ->name('admin.leads.index');
        Route::get('/create')
            ->uses([LeadController::class, 'create'])
            ->name('admin.leads.create');
        Route::post('/store')
            ->uses([LeadController::class, 'store'])
            ->name('admin.leads.store');
        Route::get('/edit/{lead}')
            ->uses([LeadController::class, 'edit'])
            ->name('admin.leads.edit');
        Route::post('/update/{lead}')
            ->uses([LeadController::class, 'update'])
            ->name('admin.leads.update');
        Route::delete('/delete/{lead}')
            ->uses([LeadController::class, 'destroy'])
            ->name('admin.leads.delete');

        Route::group(['prefix' => 'notification'], function(){
            Route::get('')
                ->uses([NotificationController::class, 'index'])
                ->name('admin.leads.notifications.index');
            Route::get('/create')
                ->uses([NotificationController::class, 'create'])
                ->name('admin.leads.notifications.create');
            Route::post('/send')
                ->uses([NotificationController::class, 'send'])
                ->name('admin.leads.notifications.send');
            Route::get('/edit/{notification}')
                ->uses([NotificationController::class, 'edit'])
                ->name('admin.leads.notifications.edit');
            Route::post('/update/{notification}')
                ->uses([NotificationController::class, 'update'])
                ->name('admin.leads.notifications.update');
            Route::delete('/delete/{notification}')
                ->uses([NotificationController::class, 'destroy'])
                ->name('admin.leads.notifications.delete');
        });
    });

    Route::group(['prefix' => 'metatags'], function(){
        Route::post('{item}/store')
            ->uses([MetaController::class, 'store'])
            ->name('admin.products.metatags');
    });
});
