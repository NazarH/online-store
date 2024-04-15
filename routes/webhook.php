<?php

use App\Http\User\Controllers\OrderController;

Route::any('order/callback')
    ->uses([OrderController::class, 'handleCallback'])
    ->name('client.order.callback');
