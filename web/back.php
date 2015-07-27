<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

if(YII_ENV == 'dev') {
	$config = require(__DIR__ . '/../back/config-dev/web.php');
} else {
	$config = require(__DIR__ . '/../back/config/web.php');
}

(new yii\web\Application($config))->run();
