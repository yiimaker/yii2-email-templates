<?php
return [
    'id' => 'test-app',
    'class' => 'yii\console\Application',
    'language' => 'en',

    'basePath' => Yii::getAlias('@tests'),
    'vendorPath' => Yii::getAlias('@vendor'),
    'runtimePath' => Yii::getAlias('@tests/_output'),

    'bootstrap' => [],
    'components' => require(__DIR__ . '/components.php'),
    'params' => require(__DIR__ . '/params.php'),
];