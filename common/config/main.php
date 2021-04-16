<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Tashkent',
    'components' => [
        'fcm' => [
            'class' => 'understeam\fcm\Client',
            'apiKey' => 'AAAAxlpAnMc:APA91bERZ5BFdYkuYXDuMOdSKZ4bkk7j0zqZ0SItrTRPHyeeODNAQGOvTCfPpqDOP0YzkTGHrOTzDafLHbdnBLrxzgFzL7vejx0x-cr9tGMsL3riSbd70pMBH2kNR4L3hG947fCtAtlK',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'cacheFrontend' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => Yii::getAlias('@frontend') . '/runtime/cache'
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ]
            ]
        ]
    ],
];
