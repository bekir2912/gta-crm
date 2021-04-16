<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-store',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'store\controllers',
//    'homeUrl' => '/',
    'name' => 'GTA',
    'language' => 'ru-RU',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-store',
//            'baseUrl' => '/',
        ],
        'user' => [
            'identityClass' => 'common\models\Seller',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-store', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-store',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'class' => 'common\components\MyFormatter',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'dashboard' => 'site/index'
            ],
        ],
//        'urlManagerFrontEnd' => [
//            'class' => 'yii\web\urlManager',
////            'baseUrl' => '/',
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//        ],

    ],
    'params' => $params,
];
