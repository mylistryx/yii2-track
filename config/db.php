<?php

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => 'mysql:host=localhost;dbname=yii2track',
    'username' => 'root',
    'password' => '123123123',
    'charset' => 'utf8mb4',

    // Schema cache options (for production environment)
    'enableSchemaCache' => YII_ENV == YII_ENV_PROD,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
