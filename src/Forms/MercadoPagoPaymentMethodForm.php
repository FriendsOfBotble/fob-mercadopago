<?php

namespace FriendsOfBotble\MercadoPago\Forms;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Forms\FieldOptions\RadioFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\RadioField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Payment\Forms\PaymentMethodForm;
use FriendsOfBotble\MercadoPago\Facades\MercadoPagoPayment;

class MercadoPagoPaymentMethodForm extends PaymentMethodForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->paymentId('mercadopago')
            ->paymentName(MercadoPagoPayment::getDisplayName())
            ->paymentDescription(__('Customer can buy product and pay directly using Visa, Credit card via :name', ['name' => MercadoPagoPayment::getDisplayName()]))
            ->defaultDescriptionValue('A conta PJ grátis para sua empresa. Simplifique a gestão da sua empresa pelo app, não importa onde você esteja.')
            ->paymentLogo(url('vendor/core/plugins/fob-mercadopago/images/mercadopago.png'))
            ->paymentUrl('https://mercadopago.com')
            ->paymentInstructions(view('plugins/fob-mercadopago::instructions')->render())
            ->add(
                get_payment_setting_key('environment', 'mercadopago'),
                RadioField::class,
                RadioFieldOption::make()
                    ->label(trans('plugins/fob-mercadopago::mercadopago.environment'))
                    ->choices([
                        'live' => trans('plugins/fob-mercadopago::mercadopago.live'),
                        'sandbox' => trans('plugins/fob-mercadopago::mercadopago.sandbox'),
                    ])
                    ->selected(get_payment_setting('environment', 'mercadopago', 'live'))
                    ->toArray()
            )
            ->add(
                get_payment_setting_key('public_key', 'mercadopago'),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/fob-mercadopago::mercadopago.public_key'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('public_key', 'mercadopago'))
                    ->toArray()
            )
            ->add(
                get_payment_setting_key('access_token', 'mercadopago'),
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/fob-mercadopago::mercadopago.access_token'))
                    ->value(BaseHelper::hasDemoModeEnabled() ? '*******************************' : get_payment_setting('access_token', 'mercadopago'))
                    ->toArray()
            )
            ->add(
                'webhook_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/fob-mercadopago::mercadopago.webhook_url'))
                    ->disabled()
                    ->value(route('payment.mercadopago.webhook'))
                    ->toArray()
            );
    }
}
