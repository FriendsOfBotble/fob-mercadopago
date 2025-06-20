<?php

namespace FriendsOfBotble\MercadoPago;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Botble\Setting\Facades\Setting;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Setting::delete([
            'payment_mercadopago_name',
            'payment_mercadopago_description',
            'payment_mercadopago_environment',
            'payment_mercadopago_public_key',
            'payment_mercadopago_access_token',
            'payment_mercadopago_status',
        ]);
    }
}
