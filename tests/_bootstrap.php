<?php
error_reporting(-1);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', false);
defined('YII_ENV') or define('YII_ENV', 'test');
defined('VENDOR_DIR') or define('VENDOR_DIR', __DIR__ . implode(DIRECTORY_SEPARATOR, ['', '..', 'vendor']));

require_once(VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php');
require_once(VENDOR_DIR . implode(DIRECTORY_SEPARATOR, ['', 'yiisoft', 'yii2', 'Yii.php']));

Yii::setAlias('@tests', __DIR__);
Yii::setAlias('@vendor', VENDOR_DIR);
Yii::setAlias('@data', __DIR__ . DIRECTORY_SEPARATOR . '_data');
