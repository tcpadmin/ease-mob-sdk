<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';
tcpadmin\EaseMobSdk\EaseMobSdk::init($config);