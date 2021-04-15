<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'bequest',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log'
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@copyleaks' => '@vendor/copyleaks'
    ],
    'defaultRoute' => 'site/front',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '12PEj2rv6ED8AMzAkEYCu00ij13OOQEf'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => [
                '/site/login'
            ]
        ],
        'formatter' => [
            'timeZone' => 'Asia/Calcutta',
            'currencyCode' => 'USD'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'shaveta@nocopycopy.ng',
                'password' => 'qiwjgcoynnmtobmd',
                //Mypass2012',
                'port' => '465',
                'encryption' => 'ssl'
            ]
        ],
        // 'mailer' => [
        // 'class' => 'yii\swiftmailer\Mailer',
        // // send all mails to a file by default. You have to set
        // // 'useFileTransport' to false and configure a transport
        // // for the mailer to send real emails.
        // 'useFileTransport' => true,
        // ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning'
                    ]
                ]
            ]
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:w+>/<id:d+>' => '<controller>/view',
                '<controller:w+>/<action:w+>' => '<controller>/<action>',
                'POST scan/completed/<scanID:[A-Za-z0-9-]+>' => 'scan/completed',
                'scan/error/<scanID:[A-Za-z0-9-]+>' => 'scan/error',
                 'scan/results/<id:[A-Za-z0-9-]+>' => 'scan/results',
                'site/register/<id:[A-Za-z0-9-]+>' => 'site/register',
                'user/assignments/<subject_code:[A-Za-z0-9-_]+>' => 'user/assignments',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>'
            ]
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '1064319501112-q8fi8i4ihsjupj4mhjg0php94d6s6965.apps.googleusercontent.com',
                    'clientSecret' => '6wzP7UiZ9Ux8gh5VxQzpOSBN',
                    'returnUrl' => 'https://nocopycopy.ng/web/site/auth?authclient=google',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '2234918070092230',
                    'clientSecret' => '3e6de79f29cc34094279bdf425160278',
                    'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name'
                    ],
                    'returnUrl' => 'https://nocopycopy.ng/web/site/auth?authclient=facebook'
                ]
            ]
        ],
        'Paystack' => [
            'class' => 'smladeoye\paystack\Paystack',
            'environment' => 'live',
            'testPublicKey'=>'',
            'testSecretKey'=>'',
            'livePublicKey'=>'pk_live_79fe0f21f145487935608709bd96183281205fa1',
            'liveSecretKey'=>'sk_live_f3e5faea4f622eb38d55f7a7b63ef4ae9ca3b42f',
            
        ],
        'socialShare' => [
            'class' => \ymaker\social\share\configurators\Configurator::class,
            'socialNetworks' => [
                'vkontakte' => [
                    'class' => \ymaker\social\share\drivers\Vkontakte::class,
                ],
                'facebook' => [
                    'class' => \ymaker\social\share\drivers\Facebook::class,
                ],
                'odnoklasniki' => [
                    'class' => \ymaker\social\share\drivers\Odnoklassniki::class,
                ],
            ],
        ],
   
    ],
    'params' => $params,
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module'
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module'
        // // uncomment the following to add your IP if you are not connecting from localhost.
        // // 'allowedIPs' => [
        // // '127.0.0.1',
        // // '::1'
        // // ]
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'model' => [
                'class' => 'app\generators\model\Generator'
            ],
            'crud' => [
                'class' => 'app\generators\crud\Generator'
            ],
            'frontend-crud' => [
                'class' => '\yii\gii\generators\crud\Generator'
            ]
        ]
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => [
        // '127.0.0.1',
        // '::1'
        // ]
    ];
}

return $config;
