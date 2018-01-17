<?php

return [
    'class' => yii\db\Connection::class,
    'dsn' => 'sqlite:' . Yii::getAlias('@tests/_output/test.db'),
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
];
