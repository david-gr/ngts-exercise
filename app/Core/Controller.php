<?php

class Controller
{
    var $vars = array();
    var $layout = 'default';

    /**
     *
     */
    function set($d) {
        $this->vars = array_merge($this->vars, $d);
    }

    /**
     *
     */
    function render($filename) {
        extract($this->vars);
        ob_start();
        require(APP_ROOT . '/Views/' . str_replace('Controller', '', get_class($this)) . '/' . $filename . '.php');
        $content_for_layout = ob_get_clean();

        if ($this->layout == false) {
            echo $content_for_layout;
        } else {
            require(APP_ROOT . '/Views/Layouts/' . $this->layout . '.php');
        }
    }

}
