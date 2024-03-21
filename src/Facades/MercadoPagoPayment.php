<?php

namespace FriendsOfBotble\MercadoPago\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getId()
 * @method static string getDisplayName()
 * @method static mixed authorize(array $data, \Illuminate\Http\Request $request)
 * @method static array refundOrder(string $chargeId, float $amount, array $options = [])
 * @method static string getLocale()
 * @method static bool getSupportRefundOnline()
 * @method static array supportedCurrencies()
 * @method static array supportedLocales()
 *
 * @see \FriendsOfBotble\MercadoPago\MercadoPagoPayment
 */
class MercadoPagoPayment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FriendsOfBotble\MercadoPago\MercadoPagoPayment::class;
    }
}
