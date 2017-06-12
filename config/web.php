<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],

        'dynamicrelations' => [
            'class' => '\synatree\dynamicrelations\Module',
        ],

        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',

            'displaySettings' => [
                'date' => 'd-m-Y',
                'time' => 'H:i:s A',
                'datetime' => 'd-m-Y H:i:s A',
            ],

            'saveSettings' => [
                'date' => 'Y-m-d',
                'time' => 'H:i:s',
                'datetime' => 'Y-m-d H:i:s',
            ],

            'autoWidget' => true,

        ],
    ],
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'session',
        ],
        'request' => [
            'baseUrl' => str_replace('/web', '', (new \yii\web\Request)->getBaseUrl()),
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'MfUsCsKe7ESAiH25TzeolSVxyAiIyCIV',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'defaultTimeZone' => 'UTC',
            'timeZone' => 'America/Lima',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'enableSession' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                /**Sesion**/
                ['pattern' => '/login', 'route' => '/site/login', 'suffix' => '.php'],

                /**home**/
                ['pattern' => '/', 'route' => '/site/index', 'suffix' => ''],

                /**Usuario**/
                ['pattern' => '/nuevo-usuario', 'route' => '/user/create', 'suffix' => '.php'],
                ['pattern' => '/lista-usuario', 'route' => '/user/index', 'suffix' => '.php'],
                ['pattern' => '/actualizar-usuario/<id:\d+>', 'route' => '/user/update'],
                ['pattern' => '/eliminar-usuario/<id:\d+>', 'route' => '/user/delete'],

                /**Proforma**/
                ['pattern' => '/nueva-proforma', 'route' => '/proforma/create', 'suffix' => '.php'],
                ['pattern' => '/lista-proforma', 'route' => '/proforma/index', 'suffix' => '.php'],
                ['pattern' => '/actualizar-proforma/<id:\d+>', 'route' => '/proforma/update'],
                ['pattern' => '/eliminar-proforma/<id:\d+>', 'route' => '/proforma/delete'],

                /**Factura**/
                ['pattern' => '/nueva-factura', 'route' => '/factura/create', 'suffix' => '.php'],
                ['pattern' => '/lista-factura', 'route' => '/factura/index', 'suffix' => '.php'],
                ['pattern' => '/actualizar-factura/<id:\d+>', 'route' => '/factura/update'],
                ['pattern' => '/eliminar-factura/<id:\d+>', 'route' => '/factura/delete'],

                /**Guia**/
                ['pattern' => '/lista-guia', 'route' => '/guia/index', 'suffix' => '.php'],
                ['pattern' => '/actualizar-guia/<id:\d+>', 'route' => '/guia/update'],
                ['pattern' => '/eliminar-guia/<id:\d+>', 'route' => '/guia/delete'],
            ],
        ],

    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'actions' => ['login', 'forgot'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
        'denyCallback' => function () {
            return Yii::$app->response->redirect(['site/login']);
        },
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'kartikgii-crud' => ['class' => 'warrence\kartikgii\crud\Generator'],
        ]
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
