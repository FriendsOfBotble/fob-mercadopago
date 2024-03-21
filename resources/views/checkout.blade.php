<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ theme_option('site_title') }}</title>
    </head>
    <body>
        <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <div id="wallet_container"></div>
        </div>

        <script src="https://sdk.mercadopago.com/js/v2"></script>

        <script>
            var mp = new MercadoPago('{{ $publicKey }}', {
                locale: '{{ $locale }}',
            });
            var bricksBuilder = mp.bricks();

            mp.bricks().create('wallet', 'wallet_container', {
                initialization: {
                    preferenceId: '{{ $preferenceId }}',
                },
                customization: {
                    texts: {
                        valueProp: 'smart_option',
                    },
                },
            });
        </script>
    </body>
</html>
