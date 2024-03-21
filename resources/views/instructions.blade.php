<ol>
    <li>
        <p>
            {!! BaseHelper::clean(trans(
                'plugins/fob-mercadopago::mercadopago.instructions.create_account',
                ['link' => Html::link('https://www.mercadopago.com', \FriendsOfBotble\MercadoPago\Facades\MercadoPagoPayment::getDisplayName(), ['target' => '_blank'])]
            )) !!}
        </p>
    </li>
    <li>
        <p>
            {!! BaseHelper::clean(trans(
                'plugins/fob-mercadopago::mercadopago.instructions.get_credentials',
                 ['link' => Html::link('https://www.mercadopago.com.co/developers/panel/app', trans('plugins/fob-mercadopago::mercadopago.instructions.your_integrations'), ['target' => '_blank'])]
            )) !!}
        </p>
    </li>

    <li>
        <p>
            {!! BaseHelper::clean(trans(
                'plugins/fob-mercadopago::mercadopago.instructions.learn_more',
                 ['link' => Html::link('https://www.mercadopago.com.co/developers/en/docs/getting-started', attributes: ['target' => '_blank'])]
            )) !!}
        </p>
    </li>
</ol>

<h4>{{ trans('plugins/fob-mercadopago::mercadopago.webhook_guide.title') }}</h4>
<p>
    {!! BaseHelper::clean(trans(
        'plugins/fob-mercadopago::mercadopago.webhook_guide.description',
        ['link' => Html::link('https://www.mercadopago.com.co/developers/en/docs/your-integrations/notifications/webhooks', attributes: ['target' => '_blank'])]
     )) !!}
</p>
