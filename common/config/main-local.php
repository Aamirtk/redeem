<?php
/**
 * Created by PhpStorm.
 * User: Chuang
 * Date: 2015/5/17
 * Time: 16:25
 */
return [

];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '10.0.2.2'] // 按需调整这里
    ];
}
