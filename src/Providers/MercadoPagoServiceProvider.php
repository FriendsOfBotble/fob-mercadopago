<?php

namespace FriendsOfBotble\MercadoPago\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use FriendsOfBotble\MercadoPago\Contracts\MercadoPagoClient as MercadoPagoClientContract;
use FriendsOfBotble\MercadoPago\Facades\MercadoPagoPayment;
use FriendsOfBotble\MercadoPago\MercadoPago\MercadoPagoConfig;
use FriendsOfBotble\MercadoPago\MercadoPagoClient;

class MercadoPagoServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        if (
            ! is_plugin_active('ecommerce') &&
            ! is_plugin_active('job-board') &&
            ! is_plugin_active('real-estate') &&
            ! is_plugin_active('hotel')
        ) {
            return;
        }

        $this->app->bind(MercadoPagoClientContract::class, function () {
            return new MercadoPagoClient(
                get_payment_setting('access_token', MercadoPagoPayment::getId()),
                get_payment_setting('environment', MercadoPagoPayment::getId(), 'live') === 'sandbox'
                    ? MercadoPagoConfig::LOCAL
                    : MercadoPagoConfig::SERVER
            );
        });
    }

    public function boot(): void
    {
        if (
            ! is_plugin_active('ecommerce') &&
            ! is_plugin_active('job-board') &&
            ! is_plugin_active('real-estate') &&
            ! is_plugin_active('hotel')
        ) {
            return;
        }

        $this
            ->setNamespace('plugins/fob-mercadopago')
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadHelpers()
            ->publishAssets()
            ->loadRoutes();

        $this->app->booted(fn () => $this->app->register(HookServiceProvider::class));
    }
}
