<?php

use App\Http\Middleware\VerifyCsrfToken;
use FriendsOfBotble\MercadoPago\Http\Controllers\MercadopagoController;
use Illuminate\Support\Facades\Route;

Route::prefix('payment/mercadopago')
    ->name('payment.mercadopago.')
    ->middleware(['core'])
    ->group(function () {
        Route::get('callback', [MercadopagoController::class, 'callback'])
            ->middleware('web')
            ->name('callback');
        Route::post('webhook', [MercadopagoController::class, 'webhook'])
            ->name('webhook');
    });
