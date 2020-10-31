<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "Motores 502", // set false to total remove
            'titleBefore'  => true, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'Si tiene motor, te ayudamos a venderlo en consignación. Carros usados y seminuevos en venta.', // set false to total remove
            'separator'    => ', ',
            'keywords'     => ['venta de carros', 'carros usados en venta', 'olx venta de carros', 'venta de carros usados', 'olx vehiculos', 'autos usados', 'toyota usados', 'usados de agencia', 'venta de autos', 'autos en venta', 'autos olx', 'venta de autos usados', 'carros de lujo', 'carros lujosos', 'autos de lujo', 'carros nuevos', 'sedan', 'hatchback',  'carros europeos', 'carros americanos', 'carros japoneses', 'carros de lujo'],
            'canonical'    => true, // Set null for using Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => true,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Motores 502', // set false to total remove
            'description' => 'Si tiene motor, te ayudamos a venderlo en consignación. Carros usados y seminuevos en venta.', // set false to total remove
            'url'         => 'https://www.motores502.com/', // Set null for using Url::current(), set false to total remove
            'type'        => 'website',
            'site_name'   => 'Motores 502',
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'Concesionario de automóviles usados en Guatemala',
            'site'        => '@Motores502',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'Motores 502', // set false to total remove
            'description' => 'Si tiene motor, te ayudamos a venderlo en consignación. Carros usados y seminuevos en venta.', // set false to total remove
            'url'         => true, // Set null for using Url::current(), set false to total remove
            'type'        => 'Página WEB',
            'images'      => [],
        ],
    ],
];
