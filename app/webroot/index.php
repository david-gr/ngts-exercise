<?php

define('APP_ROOT', dirname(dirname(__FILE__)));

require(APP_ROOT . '/Config/core.php');
require(APP_ROOT . '/Config/config.php');

require(APP_ROOT . '/router.php');
require(APP_ROOT . '/request.php');
require(APP_ROOT . '/dispatcher.php');

$dispatch = new Dispatcher();
$dispatch->dispatch();
