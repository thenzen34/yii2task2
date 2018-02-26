<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;dbname=yii2task2',
            'charset' => 'UTF-8',
            'emulatePrepare' => true,
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
        ],
    ],
];
