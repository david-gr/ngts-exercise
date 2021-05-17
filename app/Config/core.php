<?php

spl_autoload_register(function ($class_name) {
    require APP_ROOT . '/Core/' . $class_name . '.php';
});
