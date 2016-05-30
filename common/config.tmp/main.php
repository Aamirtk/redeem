<?php
// 配置文件
return [
    'id' => 'vsomaker',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'redis' => require(__DIR__ . '/redis.php'),
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '10.3.1.50',
                    'port' => 11211,
                    'weight' => 60,
                ],
                [
                    'host' => '10.3.1.50',
                    'port' => 11211,
                    'weight' => 40,
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
//            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [

            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'sphinx' => [
            'class' => 'backend\components\coreseek\CoreseekComponentNew'
        ]
    ],
];

