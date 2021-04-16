<?php

$ini = parse_ini_file("config.ini");

return [
    'appName' => 'GTA-CRM',
    'currency' => trim(file_get_contents((__DIR__).'/currency')) ,
    'adminEmail' => 'info@гта.uz',
    'infoEmail' => $ini['email'],//'info@vroom.uz',
    'salesEmail' => 'info@гта.uz',
    'user.passwordResetTokenExpire' => 3600,
    'client_support_service' => $ini['phone'],//'+99897 455 55 34',
    'ya_key' => '52dd34b7-84ab-45ed-bedc-24023fdfa601',
    'boost_price' => [
      'colored_offer' => [
          'days' => $ini['colored_days'],//'3',
          'price' => $ini['colored_price'],//'10000',
      ],
      'special_offer' => [
          'days' => $ini['special_days'],//'3',
          'price' => $ini['special_price'],//'10000',
      ],
    ],
    'balance_fill' => [
        10000,
        20000,
        30000,
        40000,
        50000,
        100000,
    ],
    'price' => [
        'decimals' => '0',
        'dec_pointer' => '',
        'thousands_sep' => ' ',
    ],
    'price_dec' => [
        'decimals' => '2',
        'dec_pointer' => ',',
        'thousands_sep' => '.',
    ],
    'imageSizes' => [
        'shops' => [
            'image' => [1599, 500],
            'logo' => [150, 150],
        ],
        'products' => [
            'image' => [636, 480],
        ],
        'services' => [
            'image' => [64, 64],
        ],
        'banners' => [
            'image' => [270, 400],
        ],
        'categories' => [
            'icon' => [150, 150],
            'image' => [500, 500],
        ],
        'brands' => [
            'logo' => [500, 500],
        ],
        'news' => [
            'image' => [500, 500],
        ],
        'options' => [
            'image' => [32, 32],
        ],
        'payments' => [
            'logo' => [300, 300],
        ],
    ],
];
